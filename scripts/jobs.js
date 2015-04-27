$("button.add").click(function()
{
    var JobId = $(this).attr('class').split(' ').slice(0,1);
    var ClassId = $("select#classes."+JobId+"").val();
    $(':input','#mainform').not(':button, :submit, :reset, :hidden').val('').removeAttr('checked').removeAttr('selected');
    $("#action").val("add");
    $("#classId").val(ClassId);
    $("#jobId").val(JobId);
});

$("button.delete").click(function()
{
    var JobId = $(this).attr('class').split(' ').slice(0,1);
    var ClassId = $("select#classes."+JobId+"").val();
    alert(ClassId);
    $(':input','#mainform').not(':button, :submit, :reset, :hidden').val('').removeAttr('checked').removeAttr('selected');
    $("#action").val("delete");
    $("#classId").val(ClassId);
    $("#jobId").val(JobId);
});