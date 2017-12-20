/**
 * Created by Administrator on 2017/11/23 0023.
 *
*/

//删除数据
function doDel(mark,id)
{
    var con = confirm('请问是否是要删除这条数据');
    if(con == true)
    {
        data = {
            id :id,
            _token:$('#token').val()

        };
        //console.log(data);
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
    //console.log(Rightses);
    $('input[name=role_rights]').val(Rightses);

    $('.form-horizontal').submit();
}

//编辑用户, 整理权限
function editUserCollatingRoles()
{
    var Role = $('.select2-search-choice');
    //把现在所选的角色,拼接成字符串,用都好分隔
    var Roles;
    $(Role).each(function()
    {
        if($(this).text() == $(Role[0]).text())
        {
            Roles = Trim($(this).text());
        }else{
            Roles += ','+Trim($(this).text());
        }
    });
    $('input[name=user_role]').val(Roles);

    $('.form-horizontal').submit();
}

function Trim(str)
{
    return str.replace(/(^\s*)|(\s*$)/g, "");
}

//删除栏目
function delColumn(mark,id)
{
    var con = confirm('请问是否是要删除这条数据');
    if(con == true)
    {
        data = {
            id :id,
            _token:$('#token').val()

        };
        //console.log(data);
        $.ajax({
            url:'/admin/'+mark+'/doDel',
            type:'post',
            async:false,
            data:data,
            success:function(data){
                if(data == 200)
                {
                    location.replace(location.href);
                }else if(data == 108){
                    alert('删除失败,此栏目还有子栏目不可删除');
                }

            }
        });
    }else{
        return false;
    }
}

function delClass(mark,id)
{
    var con = confirm('请问是否是要删除这条');
    if(con == true)
    {
        data = {
            id :id,
            _token:$('#token').val()

        };
        //console.log(data);
        $.ajax({
            url:'/admin/'+mark+'/doDel',
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
    }else{
        return false;
    }
}
