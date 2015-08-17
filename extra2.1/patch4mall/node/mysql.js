
// ref:  http://blog.csdn.net/lovingshu/article/details/41721233
// use as follow: 
/*
var query=require("./mysql.js");  
  
query("select 1 from 1",function(err,vals,fields){  
    //do something  
});  

*/

var mysql=require("mysql");  

var pool = mysql.createPool({  
    host: 'localhost',  
    user: 'root',  
    password: '',  
    database: 'nodedb',  
    port: 3306
});  
  
var query=function(sql,callback){  
    pool.getConnection(function(err,conn){  
        if(err){  
            callback(err,null,null);  
        }else{  
            conn.query(sql,function(qerr,vals,fields){  
                //释放连接  
                conn.release();  
                //事件驱动回调  
                callback(qerr,vals,fields);  
            });  
        }  
    });  
};  
  
module.exports=query;  