$('.file-select').click(function (e) {
    isDetail = false;
    $("input[name='filemanager']:checked").prop('checked',false);
    fileKey = $(this).data('key');
    //select key files
    var json = getFilePage(csrf,page,fileKey).responseJSON;
    selectFiles(json);
});

$('.file-select-detail').click(function (e) {
    isDetail = true;
    $("input[name='filemanager']:checked").prop('checked',false);
    fileKey = $(this).data('key');
    pageDetail = $(this).data('pagedetail');
    //select key files
    var json = getFilePageDetail(csrf,pageDetail,fileKey).responseJSON;
    selectFiles(json);
});

$('.file-save').click(function () {
    result = confirm(confirmText);
    if(result){
        files = $("input[name='filemanager']:checked").map(function() { return this.value; }).get();
        if(isDetail){
            saveFilePageDetail(csrf,pageDetail,fileKey,files);
            $('#filemanager').modal('hide');
        } else {
            saveFilePage(csrf,page,fileKey,files);
            $('#filemanager').modal('hide');
        }
    }
});


$('#file-input').on('change',function () {
    var file_to_upload = this.files[0];
    var form_data = new FormData();
    form_data.append('file',file_to_upload);
    form_data.append('csrf',csrf);
    uploadFormData(csrf,form_data);
});

function selectFiles(json){
    $.each(json,function (key,value) {
        $('#file_'+value.id).click();
    });
}

function getFilesWithOffset(offset){
    var response = getAllFiles(csrf,offset);
    $('.files').html('');
    printFiles(response);
}
function refreshFiles(){
    var response = getAllFiles(csrf);
    $('.files').html('');
    printFiles(response);
}
$(document).ready(function() {
    var response = getAllFiles(csrf);
    var totalFilesCount = JSON.parse(response.responseJSON).length;
    printFiles(response);
});

$('.refresh').click(function () {
    refreshFiles();

});


function getFilePage(csrf,page,key){
    return $.ajax({
        url:'/panel/getFilePage',
        method:'GET',
        data:{
            "_token": csrf,
            "page": page,
            "key":key
        },
        async: false,
        success: function (s1,s2,s3) {
        }
    });
}

function getFilePageDetail(csrf,pageDetail,key){
    return $.ajax({
        url:'/panel/getFilePageDetail',
        method:'GET',
        data:{
            "_token": csrf,
            "pageDetail": pageDetail,
            "key":key
        },
        async: false,
        success: function (s1,s2,s3) {
        }
    });
}

function saveFilePage(csrf,page,key,files){
    return $.ajax({
        url:'/panel/saveFilePage',
        method:'POST',
        data:{
            "_token": csrf,
            "page": page,
            "key":key,
            "files":files,
        },
        async: false,
        success: function (s1,s2,s3) {
        }
    });
}

function saveFilePageDetail(csrf,pageDetail,key,files){
    return $.ajax({
        url:'/panel/saveFilePageDetail',
        method:'POST',
        data:{
            "_token": csrf,
            "pageDetail": pageDetail,
            "key":key,
            "files":files,
        },
        async: false,
        success: function (s1,s2,s3) {
        }
    });
}

function getAllFiles(csrf,start=0){
    return $.ajax({
        url:'/panel/files',
        method:'GET',
        data:{
            "_token": csrf,
            "start":start
        },
        async: false,
        success: function (s1,s2,s3) {
        }
    });
}

function uploadFormData(csrf,formdata){
    return $.ajax({
        url:'/panel/uploadFile',
        processData: false,
        contentType: false,
        method: 'POST',
        data: formdata,
        success: function (s1,s2,s3) {
            refreshFiles();
            if(isDetail){
                selectFiles(getFilePageDetail(csrf,pageDetail,fileKey).responseJSON);
            } else {
                selectFiles(getFilePage(csrf,page,fileKey).responseJSON);
            }
        }
    });
}


function uploadFile(csrf,file_to_upload){
    return $.ajax({
        url:'/panel/uploadFile',
        method:'POST',
        dataType:'JSON',
        data:{
            "_token": csrf,
            "file": file_to_upload,
        },
        cache:false,
        processData: false,
        async: false,
        success: function (s1,s2,s3) {
        }
    });
}

function printFiles(response){
    $.each(JSON.parse(response.responseJSON),function (key,value) {
        if(jQuery.inArray( value.extension ,imgExtensions) !== -1){
            $('.files').append(
                '<div class="form-group col-3 float-left  border border-primary" onclick="$(\'#file_'+value.id+'\').click();">'+
                '<img src="/storage/'+value.path+'" style="width:inherit;"/>'+
                '<input type="checkbox" class="form-group" name="filemanager" value="'+value.id+'" id="file_'+value.id+'">'+
                '<label for="file_'+value.id+'" onclick="$(\'#file_'+value.id+'\').click();">'+
                ' '+value.name+'.'+value.extension+'</label>'+
                '</div>'
            );
        } else {
            var icon;
            if(value.extension == "pdf"){ icon = "pdf";}
            else if(value.extension == "ppt" || value.extension == "pptx"){ icon = "powerpoint";}
            else if(value.extension == "doc" || value.extension == "docx"){ icon = "word";}
            else if(value.extension == "xls" || value.extension == "xlsx"){ icon = "excel";}
            else if(value.extension == "mp4" || value.extension == "mpeg" || value.extension == "avi"){ icon = "video";}
            else{ icon = "outline";}
            $('.files').append(
                '<div class="form-group col-3 float-left  border border-primary" onclick="$(\'#file_'+value.id+'\').click();">'+
                '<i class="mdi mdi-file-'+icon+'" style="font-size:100px;"></i>'+
                '<input type="checkbox" class="form-group" name="filemanager" value="'+value.id+'" id="file_'+value.id+'">'+
                '<label for="file_'+value.id+'" onclick="$(\'#file_'+value.id+'\').click();">'+
                ' '+value.name+'.'+value.extension+'</label>'+
                '</div>'
            );
        }

    });
}
