function dataStructure() {
    this.data = {};
    this.setData = function (key, data) {
        this.data[key] = data
    }
    this.getData = function (key) {
        return this.data[key];
    }
    this.cleanData=function(){
        this.data={}
    }

}

var controller=new dataStructure();
var userPermission = {};

var clearForm=function(id){
    $('#'+id+' input').val('');
    $('#'+id+' textarea').val('');
    $('#'+id+' select').val('-1').trigger("chosen:updated");;
    $('#'+id+' div.form-group').removeClass('has-success');
    $('#'+id+' div.form-group').removeClass('has-error');
    $('#'+id+' span.help-block').remove();
    
}
