<?php

namespace App\Controllers;

use Myth\Auth\Models\UserModel;
use \Myth\Auth\Authorization\GroupModel;
use App\Models\AnggotaModel;

use \Myth\Auth\Entities\User;
use \Myth\Auth\Config\Auth as AuthConfig;

class Admin extends BaseController
{
    protected $db;
    protected $auth, $AnggotaModel;
    protected $builder, $builder0, $builder1, $builder2, $query, $query0, $query1, $query2, $result, $result0, $result1, $result2;

    protected $config;
    public function __construct()
    {
        $this->AnggotaModel = new AnggotaModel();

        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('users');
        $this->builder1 = $this->db->table('auth_groups');
        $this->builder2 = $this->db->table('auth_groups_users');

        $this->config = config('Auth');
        $this->auth = service('authentication');
    }

    public function index()
    {
        $data['title'] = 'User List';
        // $users = new \Myth\Auth\Models\UserModel();
        // $data['users'] = $users->findAll();

        $this->builder->select('users.id as userid, username, email, active, name, description,created_at');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $query = $this->builder->get();
        $data['users'] = $query->getResult();

        $groupModel = new GroupModel();

        foreach ($data['users'] as $row) {
            $dataRow['group'] = $groupModel->getGroupsForUser($row->userid);
            $dataRow['row'] = $row;
            $data['row' . $row->userid] = view('Admin/row', $dataRow);
        }

        $data['groups'] = $groupModel->findAll();

        return view('Admin/index', $data);
    }

    public function changeGroup()
    {
        $this->db = db_connect();
        $jml_admin = $this->db->table('auth_groups_users')->like('group_id', 3)->countAllResults();

        $userId = $this->request->getVar('id');
        $groupId = $this->request->getVar('group');
        $this->builder2->like('user_id', $userId);
        $this->builder2->select('*');
        $this->query2 = $this->builder2->get();
        $datauser = $this->query2->getResult();
        // d($datauser);
        //cek yg dimodif data admin / tidak

        if ($datauser[0]->group_id == 3) { //yg dimodif data admin
            //mengubah admin jadi role lain atau tidak
            if ($groupId == 3) { //admin tdk berubah role
                // session()->setFlashdata('pesan', 'tdk berubah');
                return redirect()->to(base_url('/admin/index'));
            } else { //admin berubah role
                if ($jml_admin > 1) { //jml admin > 1
                    $groupModel = new GroupModel();
                    $groupModel->removeUserFromAllGroups(intval($userId));

                    $groupModel->addUserToGroup(intval($userId), intval($groupId));
                } else { //jml admin < 1
                    session()->setFlashdata('pesan', 'Minimal harus ada 1 admin');
                    return redirect()->to(base_url('/admin/index'));
                }
            }
        } else { //yg dimodif bukan data admin
            $groupModel = new GroupModel();
            $groupModel->removeUserFromAllGroups(intval($userId));

            $groupModel->addUserToGroup(intval($userId), intval($groupId));
        }

        return redirect()->to(base_url('/admin/index'));
    }

    public function detail($id = 0)
    {
        $data['title'] = 'User Detail';

        $this->builder->select('users.id as userid, username, email, name, description,created_at');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->builder->where('users.id', $id);
        $query = $this->builder->get();
        $data['user'] = $query->getRow();

        if (empty($data['user'])) {
            return redirect()->to('/admin');
        }
        return view('admin/detail', $data);
    }

    public function delete()
    {
        $id = $this->request->getVar('id_del');

        $users = new UserModel();

        $users->deleteuser($id);
        return redirect()->to(base_url('/admin/index'));
    }

    public function add()
    {
        $anggota = $this->AnggotaModel->findAll();

        $data = [
            'title' => 'Add Users',
            'config' => $this->config,
            'anggota' => $anggota,

        ];

        return view('admin/add2', $data);
    }

    public function save()
    {
        $users = model(UserModel::class);

        $rules = [
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $rules = [
            'password'     => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Save the user
        $allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
        $user = new User($this->request->getPost($allowedPostFields));

        $this->config->requireActivation === null ? $user->activate() : $user->generateActivateHash();

        // Ensure default group gets assigned if set
        if (!empty($this->config->defaultUserGroup)) {
            $users = $users->withGroup($this->config->defaultUserGroup);
        }

        if (!$users->save($user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        if ($this->config->requireActivation !== null) {
            $activator = service('activator');
            $sent = $activator->send($user);

            if (!$sent) {
                return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
            }

            // Success!
            return redirect()->to(base_url('/admin/index'));
        }

        // Success!
        return redirect()->to(base_url('/admin/index'));
    }

    public function activate()
    {
        $userModel = new UserModel();

        $data = [
            'activate_hash' => null,
            'active' => $this->request->getVar('active') == '0' || '' ? '1' : '0',
        ];
        $userModel->update($this->request->getVar('id'), $data);

        return redirect()->to(base_url('/admin/index'));
    }

    public function getId()
    {
        if ($this->request->isAJAX()) {
            $kode = $this->request->getGet('kode');

            $db = $this->AnggotaModel->where('id_anggota', $kode)->findAll();
            $db2 = $this->AnggotaModel->where(['id_anggota' => $kode])->first();
            // $this->builder->where('anggota.id_anggota', $kode);

            // $this->query = $this->builder->get();


            // $this->result = $this->query->getResult();

            // $anggota = $this->result;

            if ($db == NULL) {
                $data = [];
            } else {
                $username = $db[0]['id_anggota'];
            }
            $data = [
                'username' => $username,
            ];
            return $this->response->setJSON($db);
        }
    }
}
