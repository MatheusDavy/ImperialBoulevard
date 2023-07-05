"use strict";
var backupCommon;

function BackupCommon() {
	this.init();
};

BackupCommon.prototype.init = function(){
	var self = this;
	self.backupCommon();
}
BackupCommon.prototype.backupCommon = function(){
    $('#backup').on('click', function (e) {
        e.preventDefault();
        window.open($(this).attr('url') + '/' + $('#select-backup').val(), '_blank');
        document.location.reload(true);
    });

    $('#backup').on('click', function (e) {
        e.preventDefault();
        window.open($(this).attr('url') + '/' + $('#select-backup').val(), '_blank');
        document.location.reload(true);
    });

    $('#download').on('click', function (e) {
        e.preventDefault();
        window.open($(this).attr('url') + '/' + $('#select-download').val(), '_blank');
        document.location.reload(true);
    });
}
$(document).ready(function(){
	backupCommon = new BackupCommon();
});
