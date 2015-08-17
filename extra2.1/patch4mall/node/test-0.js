

var express = require('express')
var app = express();


app.get('/node/hello', function(req,res){
   res.send(" is s /node/hello ");
});



// ---------------  start server and listen  
// -

app.get('/hello', function(req, res){
   res.send('hello world')
});

var server = app.listen(3000, function() {
   console.log('listening on port %d', server.address().port);

});


module.exports = app;


