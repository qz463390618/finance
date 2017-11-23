/**
 * Created by Administrator on 2017/11/23 0023.
 *
*/

//删除数据
function doDel(mark,id)
{
    var con = confirm('请问是否是要删除这条权限');
    if(con == true)
    {
        data = {
            id :id,
            _token:$('#token').val()

        };
        console.log(data);
        $.ajax({
            url:'/admin/rbac/'+mark+'/doDel',
            type:'post',
            async:false,
            data:data,
            success:function(data){
                if(data == 1)
                {
                    location.replace(location.href);
                }else{
                    alert('删除失败');
                }
            }
        });
    }
}

//编辑角色,整理权限
function editRoleCollatingRights()
{
    var Rights = $('.select2-search-choice');

    //把现在所选的权限,拼接成字符串,用都好分隔
    var Rightses;
    $(Rights).each(function()
    {
        if($(this).text() == $(Rights[0]).text())
        {
            Rightses = Trim($(this).text());
        }else{
            Rightses += ','+Trim($(this).text());
        }
    });
    console.log(Rightses);
    $('input[name=role_rights]').val(Rightses);

    $('.form-horizontal').submit();
}

function Trim(str)
{
    return str.replace(/(^\s*)|(\s*$)/g, "");
}
