/**
 * Created by Vilim Stubičan on 9.4.2015..
 */

app.service("imageUpload", function($rootScope, $http){
    var imageUploadService = {
        formId : "fileUploadForm",
        fileInput : "file",
        uploadUrl : "/admin/image/upload",
        images : [],
        currentImage : 0,
        uploadNumber : 0,
        uploading : false,

        init : function(){
            var selfImageUpload = this;
            $(document).ready(function(){
                $("#"+selfImageUpload.fileInput).on("change",function(){
                    selfImageUpload.upload();
                })
            });
        },
        upload : function(){
            if(this.uploading) return;
            this.uploading = true;
            this.currentImage = 0;
            var selfImageUpload = this;
            var files = document.getElementById(this.fileInput).files;
            this.uploadNumber = files.length;
            if(this.uploadNumber == 0) return;
            for(k=0;k<files.length;k++) {
                var file = files[k];
                var formData = new FormData();
                formData.append("file", file);
                $http.post(
                    this.uploadUrl,
                    formData,
                    {
                        transformRequest: angular.identity,
                        headers: {
                            'Content-Type': undefined
                        }
                    }
                ).success(function(data){
                        selfImageUpload.images.push(data.data);
                        selfImageUpload.currentImage++;
                        console.log(selfImageUpload.currentImage);
                        console.log(selfImageUpload.uploadNumber);
                        if(selfImageUpload.currentImage == selfImageUpload.uploadNumber) {
                            selfImageUpload.uploading = false;
                            $("#"+selfImageUpload.formId)[0].reset();
                            $rootScope.$broadcast("imageUploaded");
                        }
                })
            }

        }
    };
    return imageUploadService;
});