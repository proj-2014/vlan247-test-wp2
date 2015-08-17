
// =========================   Test01:  mysql
/*
var mysql = require('mysql');
var conn = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database:'nodedb',
    port: 3306
});
conn.connect();
conn.query('SELECT 1 + 1 AS solution', function(err, rows, fields) {
    if (err) throw err;
    console.log('The solution is: ', rows[0].solution);
});
//conn.end();

// ========== part2: add follow test code 

/*
var mysql = require('mysql');
var conn = mysql.createConnection({
    host: 'localhost',
    user: 'nodejs',
    password: 'nodejs',
    database: 'nodejs',
    port: 3306
});
conn.connect();
*/


var mysql = require('mysql');
var conn = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'root',
    database: 'db_test_extra3',
    port: 3306
});



var insertSQL = 'insert into t_user(name) values("conan"),("fens.me")';
var selectSQL = 'select * from t_user limit 10';
var deleteSQL = 'delete from t_user';
var updateSQL = 'update t_user set name="conan update"  where name="conan"';


conn.query(deleteSQL, function (err0, res0) {
    if (err0) console.log(err0);
    console.log("DELETE Return ==> ");
    console.log(res0);

    //insert
    conn.query(insertSQL, function (err1, res1) {
        if (err1) console.log(err1);
        console.log("INSERT Return ==> ");
        console.log(res1);

        //query
        conn.query(selectSQL, function (err2, rows) {
            if (err2) console.log(err2);

            console.log("SELECT ==> ");
            for (var i in rows) {
                console.log(rows[i]);
            }

            //update
            conn.query(updateSQL, function (err3, res3) {
                if (err3) console.log(err3);
                console.log("UPDATE Return ==> ");
                console.log(res3);

                //query
                conn.query(selectSQL, function (err4, rows2) {
                    if (err4) console.log(err4);

                    console.log("SELECT ==> ");
                    for (var i in rows2) {
                        console.log(rows2[i]);
                    }
                });
            });
        });
    });
});

//conn.end();

*/









// ===========================  Test02:  Rest API

var express = require('express')
var app = express();

var products = [
   { name: 'apple juice', description: 'good', price: 12.12 },
   { name: 'banana juice', description: 'just so sos', price: 4.50 }
]

app.get('/products', function(req, res) {
   res.json(products);
});

// -----------------  GET /products/:id => 404

app.get('/products/:id', function(req, res) {
   if (products.length <= req.params.id || req.params.id < 0) {
      res.statusCode = 404;
      return res.send('Error 404: No products found')
   }
   res.json(products[req.params.id]);
})


// -------------------------------  POST 
// test by curl:  curl -X POST -H "Content-type:application/json" -d '{"name":"aaa","description":"bbb","price":"33"}' http://127.0.0.1:3000/products
bodyParser = require('body-parser');

app.use(bodyParser.json());
//app.use(bodyParser.urlencoded({extend:true}));

app.post('/products', function(req, res) {
	 
	 if (typeof req.param('name') === "undefined" ||
      typeof req.param('description') === "undefined" ||
      typeof req.param('price') === "undefined") {
      res.statusCode = 400;
      res.send('Error 400: products properties missing');
   }
   
   
   var newProduct = {
      name: req.param('name'),
      description: req.param('description'),
      price: req.param('price')
   }

   products.push(newProduct);
   console.log(newProduct);
   res.statusCode = 201;
   res.location('/products/' + products.length);
   res.json(true);

});



// ==================  Test03 :  views and template nunjucks
/*
var nunjucks = require('nunjucks');

var env = new nunjucks.Environment( 
    new nunjucks.FileSystemLoader(
        ['public/tpl', 'views']
));
env.express( app );



app.get('/tpl', function(req,res){
	
	 res.render('test.tpl', {page_name: 'abc'});
});
*/
/*
var staticDir = path.join(__dirname,'public');
app.use('/static', express.static(staticDir));
*/
/*
var testRouter = require('./test_router');
app.use('/test', testRouter);
*/



// ==================  Test04 :  download image
// ref1: http://www.jb51.net/article/66847.htm
// ref2: https://cnodejs.org/topic/5378720ed6e2d16149fa16bd



function download(resource){
	 
	 var request = require('superagent');
   var fs = require('fs');
	 
	 resource.forEach(function (src, idx) {
    	 var filename = src.substring(src.lastIndexOf('/') + 1);
    	 filename = idx + "-" + filename;
    	 var writestream = fs.createWriteStream("others/download/" + filename);
    	 
    	 var req = request.get(src);    	 	 
    	 req.pipe(writestream);
    	 
    	 writestream.on('finish', function () {
            console.log(' download finish: ' + filename);
          });
   });
	 
}

var imgs = [
   "http://img13.360buyimg.com/n0/jfs/t208/225/2210482347/422450/f9fea9b7/53c79b41Nd48c98d8.jpg",   
   "http://img13.360buyimg.com/n1/jfs/t208/225/2210482347/422450/f9fea9b7/53c79b41Nd48c98d8.jpg",
   "http://img13.360buyimg.com/n2/jfs/t208/225/2210482347/422450/f9fea9b7/53c79b41Nd48c98d8.jpg",
   "http://img13.360buyimg.com/n3/jfs/t208/225/2210482347/422450/f9fea9b7/53c79b41Nd48c98d8.jpg",
   "http://img13.360buyimg.com/n4/jfs/t208/225/2210482347/422450/f9fea9b7/53c79b41Nd48c98d8.jpg",
   "http://img13.360buyimg.com/n5/jfs/t208/225/2210482347/422450/f9fea9b7/53c79b41Nd48c98d8.jpg"
   ];
   
     

//download(imgs);


// ==================  Test05 :  test the encode of some chinaese by page from superagent

/*
var Iconv = require('iconv').Iconv;
var iconv = new Iconv('GBK', 'UTF-8);
*/
// ÓÃ superagent-charset ½â¾ö

function getDetail(url){
	
	      var imgs = [];
	      //var request = require('superagent');
	      var cheerio = require('cheerio');
	      var request = require('superagent-charset');
	      console.log(url);
	      
	      //var  buffers = [], size = 0;
	      
        request
            .get(url)
            .charset('gbk')
            .end(function(err, sres){
                if(err){
                    //return next(err);
                    console.log(err);
                    return err;
                }
                //var $ = cheerio.load(sres.text);
                var $ = cheerio.load(sres.text, {decodeEntities: false});
                //console.log(sres.text);
                var items = [];
                $('.spec-items img').each(function (idx, element){
                    var $element = $(element);
                    items.push({
                        src: $element.attr('src'),
                        alt: $element.attr('alt')
                        //inner: $element.innerHtml()
                        
                    });
                    imgs.push($element.attr('src'));
                    //var src = processSrc($element.attr('src'));
                    //imgs.push(src);
                    
                });
                console.log(items);
                //download(imgs);         // download images    
                //res.send(items);
            });
}

//getDetail("http://item.jd.com/1126117984.html");

// ==================  Test06 :  test mysql pool

function test06(){
	
    var query=require("./mysql.js");  
      
    query("select 1 from 1",function(err,vals,fields){  
        //do something  
        console.log("mysql query ok");
    });  
    
    var selectSQL = 'select * from t_user limit 10';
    query( selectSQL , function(err,vals,fields){
    	
    	  console.log("SELECT ==> ");
        for (var i in vals) {
            console.log(vals[i]);
        }
    });
    
    var insertSQL = 'insert into t_user(name) values("ddccee"),("zziiuu.oo-2")';
    query( insertSQL,  function(err,res,fields){
    	  console.log("INSERT Return ==> ");
        console.log(res);
    });
    
    var newName = "ddccee-new";
    var updateSQL = 'update t_user set name="' + newName + '"  where name="ddccee"';
    query( updateSQL, function(err,res, fields){
    	    console.log("UPDATE Return ==> ");
          console.log(res);
    });
    
    
    var delName = "zziiuu.oo";
    var deleteSQL = 'delete from t_user where name="' + delName + '"';
    query( deleteSQL, function(err,res, fields){
    	    console.log("DELETE Return ==> ");
          console.log(res);
    });
    
    
}

test06();



// ---------------  start server and listen  

app.get('/hello', function(req, res){
   res.send('hello world')
});

var server = app.listen(3000, function() {
   console.log('listening on port %d', server.address().port);

});


module.exports = app;

