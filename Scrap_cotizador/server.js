var cheerio = require('cheerio');
var request = require('request');
var mysql = require('mysql');
var fs = require('fs');


//Setiando los datos y estableciendo conexion con las base datos
var con = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "",
  multipleStatements: true
});

con.connect(function(err) {
  if (err) throw err;
});


var consulta_enlaces = "select relacion_tm.ENLACE_PT as enlace , relacion_tm.ID_MOVIL as id,tienda.NOMBRE_TIENDA as tienda  from cotizadorbd.relacion_tm, cotizadorbd.tienda where relacion_tm.ID_TIENDA = tienda.ID_TIENDA"
var respuestas = [];
var request_completas = 0;


con.query(consulta_enlaces, function(err, resultado) {
  if (err) {
    throw err;
  }

  for (var index in resultado) {
    (function(index) {
      request(resultado[index].enlace, function(error, response, html) {
        if (!error) {
          aux_obj = {
            html: html,
            tienda: resultado[index].tienda,
            enlace: resultado[index].enlace
          };
          console.log(enlace: resultado[index].enlace);
          respuestas.push(aux_obj);
          request_completas++;
          if (request_completas == resultado.length) {

            for (var index2 in respuestas) {
              (function(index2) {

                if (respuestas[index2].tienda === "Paris") {
                  var $ = cheerio.load(respuestas[index2].html);
                  $(".price.offerPrice.bold").filter(function() {
                    var precio = $(this).text().trim().replace(/\$/, "").replace(/\./, "");
                    if (!isNaN(precio)) {
                      con.query('update cotizadorbd.relacion_tm set relacion_tm.PRECIO_CLP = ? WHERE relacion_tm.ENLACE_PT = ? ', [precio, respuestas[index2].enlace])
                    }
                  });
                }

                if (respuestas[index2].tienda === "ABC DIN") {
                  var $ = cheerio.load(respuestas[index2].html);

                  $('div.internetPrice span[itemprop="price"]').filter(function() {
                    var precio = $(this).html().replace(/\./, "");

                    if (!isNaN(precio)) {
                      con.query('update cotizadorbd.relacion_tm set relacion_tm.PRECIO_CLP = ? WHERE relacion_tm.ENLACE_PT = ? ', [precio, respuestas[index2].enlace])
                    }
                  });
                }

                if (respuestas[index2].tienda === "Ripley") {

                  var $ = cheerio.load(respuestas[index2].html);


                  $('span[itemprop="lowPrice"]').filter(function() {

                    var precio = $(this).html().replace(/\./, "").replace(/\$/, "");

                    if (!isNaN(precio)) {
                      con.query('update cotizadorbd.relacion_tm set relacion_tm.PRECIO_CLP = ? WHERE relacion_tm.ENLACE_PT = ? ', [precio, respuestas[index2].enlace])
                    }
                  });

                  $('span[itemprop="price"]').filter(function() {

                    var precio = $(this).html().replace(/\./, "").replace(/\$/, "");

                    if (!isNaN(precio)) {
                      con.query('update cotizadorbd.relacion_tm set relacion_tm.PRECIO_CLP = ? WHERE relacion_tm.ENLACE_PT = ? ', [precio, respuestas[index2].enlace])
                    }
                  });
                }

                if (respuestas[index2].tienda === "Falabella") {
                  var $ = cheerio.load(respuestas[index2].html);

                  $("script").filter(function() {
                    var script = $(this).html().match(/"Oferta","originalPrice":"\d+\.\d+","symbol":"\$","type":3/g);

                    if (script) {
                      var precio = script[0].match(/\d{1,3}(\.\d{3})+/g);
                      var precio_parse = precio[0].replace(".", "");
                      if (!isNaN(precio_parse)) {

                        con.query('update cotizadorbd.relacion_tm set relacion_tm.PRECIO_CLP = ? WHERE relacion_tm.ENLACE_PT = ? ', [precio_parse, respuestas[index2].enlace])
                      }
                    }
                  });

                }


              })(index2);
            }
          }
        }
      });
    })(index);

  }


});



//  else
