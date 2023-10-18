var clone = $('div.content').clone(true);
console.log(clone);
$('div.content select').chosen();

jQuery('.add-more-form').click(function() {
    var parent = jQuery('div.content').last();
    clone.clone(true).insertAfter(parent);
    $('div.content:last select').chosen();
});
$(clone).find(".change").html("<a style='margin: 15px 0px;' class='btn btn-danger remove'>Remove</a>");
// $(clone).find(".tanggal_waktu").html("<div class='tanggal_waktu col-md-4'><div class='form-group mb-2'><label for=''>Tanggal</label><input id='input_tanggal' type='text' name='tanggal[]' class='form-control' required placeholder='Enter Name'></div></div>");
$(clone).find(".tanggal").html("<div class='tanggal_waktu col-md-4'></div>");

$("body").on("click", ".remove", function() {
    $(this).parents("#content").remove();
});