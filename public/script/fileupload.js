/**
 * Created by Ravuthz on 3/22/2015.
 */


function File(){

    this.checkFile = function(file){
        if(file){
            var fileSize = 0;
            if(file.size > 1024 * 1024)
                fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + " MB";
            else
                fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + " MB";

            alert(
                "File Name : " + file.name +
                "File Size : " + fileSize +
                "File Type : " + file.type
            );
        }
    };

    this.uploadFile = function(fileToUpload, toPage){
        var fd = new FormData();
        fd.append(fileToUpload, document.getElementById(fileToUpload).file[0]);

        var xhr = new XMLHttpRequest();
        xhr.upload.addEventListener("progress", uploadProgress, false);
        xhr.addEventListener("load", uploadComplete, false);
        xhr.addEventListener("error", uploadFaild, false);
        xhr.open("POST", toPage);
        xhr.send(fd);
    };

    this.uploadProgress(event){
        if(event.lengthComputable){
            var percentComplete = Math.round(event.loaded * 100 / event.total);
            document.getElementById("progressNumber");
        }
    }
}