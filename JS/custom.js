// GLOBALS
var dataset = "";
var arrayOfAvailableTags = [[]];
var arrayOfDocTags = [[]];
var docName;

//ON DOC READY
$(document).ready(function() {
    // notifications
    $("#positive-alert").hide();
    $("#negative-alert").hide();

    // modal ui
    $('#assign-tag-modal').on('hidden.bs.modal', function() {
        var attrdropdown = document.getElementById("attribute-selection-dropdown");
        attrdropdown.setAttribute("disabled", "");
    });

    // search
    $("#search-bar").keyup(function(event) {
        if (event.keyCode == 13 || event.keyCode == 8 || event.keyCode == 46) {
            event.preventDefault();
            $("#search-bar-button").click();
        }
    });

    $("#search-bar-button").on("click", function() {
        var searchitem = $("#search-bar").val();
        var textarea = $(".formatted-content").val();
        if (event.keyCode == 8 || event.keyCode == 46) {
            if (searchitem == "") {
                $(".formatted-content").unmark(options);
            }
        } else if (searchitem != "") {
            var options = {
                "className": "mark",
                "accuracy": "exactly",
                "diacritics": true,
                "caseSensitive": false
            };
            $(".formatted-content").mark(searchitem, options);
        }
    });

    getAvailableTags();


    //removing chrome fakepath
    $("#upload-file-info").on("DOMSubtreeModified", function() {
      var text = $('#upload-file-info').html();
      text = text.substring(text.lastIndexOf("\\") + 1, text.length);
      $('#upload-file-info').html(text);
    });


    // $("#previous-search-button").on("click", function() {
    //   var searchField = $("#search-bar").val();
    //     console.log("previous");
    //     console.log(dataset);
    //     console.log(searchField);
    //     if(dataset != "" && searchField != ""){
    //           $(document).scrollTop($(this).parent().next().offset().top);
    //     }
    // });
    //
    // $("#next-search-button").on("click", function() {
    //     var searchField = $("#search-bar").val();
    //     console.log("next");
    //     $("mark").scrollTop($(this).parent().next().offset().top);
    //     return false
    //     // if(dataset != "" && searchField != ""){
    //     //
    //     // }
    // });

    $('#document-textarea').on('mouseover mouseenter', '.mark', function() {
      var txt = $(this).html();
      //var count = $("mark").length;
      var count = getCountOfMarks(txt);
      var message = "There are " + count + " counts of '" + txt + "'.";

        $(this).tooltipster({
            theme: 'tooltipster-light',
            functionBefore: function(instance, helper) {
                instance.content(message);
            }
        });
        $(this).tooltipster('open');
    });


    // load doc handlers
    $("#load-modal-button").on("click", function() {
        getAvailableFiles();
    });


    //downloads
    $("#export-modal-button").on("click", function() {

      var doc = document.getElementById("exportDoc");
      var visual = document.getElementById("exportVisual");
      var schema = document.getElementById("exportSchema");
      var canvas = document.getElementById("canvas");

      doc.onclick = function(){
        if(docName != null) {
          var link = "UserFiles\\Files\\" + docName;
          doc.href = link;
          doc.setAttribute("download",docName);
          doc.click();

          successDownload();

        } else {
          $("#negative-alert").html("<strong>Please load a document!</strong>");
          $("#negative-alert").fadeIn("slow", function() {
              setTimeout(function() {
                  $("#negative-alert").fadeOut("slow");
              }, 2000);
          });
        }

      }




      visual.onclick = function() {

          if(canvas != null) {

            visual.href = canvas.toDataURL();
            visual.download = "visualisation.png";
            visual.click();

            successDownload();
          } else {
            $("#negative-alert").html("<strong>Please use a frequency analysis first!</strong>");
            $("#negative-alert").fadeIn("slow", function() {
                setTimeout(function() {
                    $("#negative-alert").fadeOut("slow");
                }, 2000);
            });
          }

      }


        schema.onclick = function(){

            var link = "schema.xsd";
            schema.href = link;
            schema.setAttribute("download", link);
            schema.click();
            successDownload();
          }




        // setDocDownload();
        // setTimeout(function() {
        //     $("#positive-alert").html("<strong>Download Successful!</strong>");
        //     $("#positive-alert").fadeIn("slow", function() {
        //         setTimeout(function() {
        //             $("#positive-alert").fadeOut("slow");
        //         }, 2000);
        //     });
        // }, 2000);
    });



    $("#file-load").on("click", function() {
        var file = $("#selected-file").html();        
        if (file == "") {
            $("#negative-alert").html("<strong>Please select a document!</strong>");
            $("#negative-alert").fadeIn("slow", function() {
                setTimeout(function() {
                    $("#negative-alert").fadeOut("slow");
                }, 2000);
            });
        } else {
          clearVisualisation();
            loadFile(file);
            $("#load-modal").delay(1000).fadeOut('slow');
            setTimeout(function() {
                $("#load-modal").modal('hide');
            }, 1500);

            setTimeout(function() {
                $("#positive-alert").html("<strong>Load Successful!</strong>");
                $("#positive-alert").fadeIn("slow", function() {
                    setTimeout(function() {
                        $("#positive-alert").fadeOut("slow");
                    }, 2000);
                });
            }, 2000);
        }

    });

    // upload server AJAX
    $("#upload-form").ajaxForm({
        url: 'ServerFiles/upload.php',
        type: 'post',
        success: function() {
            $("#upload-modal").delay(1000).fadeOut('slow');
            setTimeout(function() {
                $("#upload-modal").modal('hide');
            }, 1500);

            setTimeout(function() {
                $("#positive-alert").html("<strong>Upload Successful!</strong>");
                $("#positive-alert").fadeIn("slow", function() {
                    setTimeout(function() {
                        $("#positive-alert").fadeOut("slow");
                    }, 2000);
                });
            }, 2000);
        },
        clearForm: true
    });



    // assign tags
    $("#assign-tags-form").ajaxForm({
        url: 'ServerFiles/assign.php',
        type: 'post',
        beforeSubmit: function(formData, formObject, formOptions){
          var filename = $(".formatted-content").attr("id");
          var text = dataset;
          var searchTerm = $("#selected-word").val();
          var selElement = $(".active").html();
          var selAttribute = $("#selected-attr").val();
          var selValue = $("#new-value").val();

          var updatedXML = addTagToXML(text, searchTerm, selElement, selAttribute, selValue);

          dataset = updatedXML;

          //console.log(updatedXML);

          formData.push(
            {name: 'updatedXML',value: updatedXML},
            {name: 'filename',value: filename}
        );
        },
        success: function() {
            $("#assign-tag-modal").delay(1000).fadeOut('slow');
            setTimeout(function() {
                $("#assign-tag-modal").modal('hide');
            }, 1500);

            clearVisualisation();
            loadFile(docName);


            setTimeout(function() {
                $("#positive-alert").html("<strong>Assign Successful!</strong>");
                $("#positive-alert").fadeIn("slow", function() {
                    setTimeout(function() {
                        $("#positive-alert").fadeOut("slow");
                        $("#assign-tags-form").trigger('reset');
                    }, 2000);
                });
            }, 2000);

        },
        clearForm: true
    });

});


function successDownload() {
  $("#positive-alert").html("<strong>Download Successful!</strong>");
  $("#positive-alert").fadeIn("slow", function() {
      setTimeout(function() {
          $("#positive-alert").fadeOut("slow");
      }, 2000);
  });
}

/**
* @name addTagToXML
* @description Adds tag to XML
* @param {string} - text - Text to add tag to
* @param {string} - searchTerm - Text to replace with tag
* @param {string} - listelement - Schema Element to enclose tag
* @param {string} - attribute - Schema Attribute for tag
* @param {string} - value - User Value for tag
*/
function addTagToXML(text, searchTerm, selElement, selAttribute, selValue) {
  var textAsArray = text.split(" ");
  var checkElement = "<" + selElement;

  var interimArray = textAsArray.map(function(el, i, arr) {
    if(el.indexOf(checkElement) > -1) {
      return "";
    } else {
      return el;
    }
  });

  var interimArray2 = interimArray.map(function(el, i, arr) {
    if(el === searchTerm) {
      var element = document.createElement(selElement);
      var attr1 = element.setAttribute(selAttribute, selValue);
      element.textContent = el;
      return element.outerHTML;

    } else {
      return el;
    }
  });

  var output = interimArray2.map(function(el, i, arr) {
    if(el == "") {
      return textAsArray[i];
    } else {
      return el;
    }
  });

  return output.join(" ");
};




// RIGHT CLICK MENU
$(function() {
    $.contextMenu({
        selector: '.right-click-menu',
        callback: function(key, options) {

            var sel = getSelectionText();
            //var m = "Clicked on " + key + " on element " + sel;
            //window.console && console.log(m) || alert(m);

            if (key == "analyse-key1") {
                //console.log(sel);
                clearVisualisation();
                wordContext(sel);

            }

            if (key == "analyse-key2") {
                clearVisualisation();
                wordCloud();
            }

            if (key == "analyse-key3") {
                clearVisualisation();
                tagCloud();
            }

        },
        items: {
            "assign-tags": {
                name: "Assign Tags",
                callback: function(key, options) {
                    var sel = getSelectionText();
                    getAvailableTagsToRender();
                    //triggered when modal is about to be shown
                    $('#assign-tag-modal').on('show.bs.modal', function(e) {
                        //populate the textbox
                        $(e.currentTarget).find('input[name="selection"]').val(sel);
                    });
                    $("#assign-tag-modal").modal();


                }
            },
            "analyse": {
                "name": "Analyse",
                "items": {
                    "analyse-key1": {
                        "name": "Word Context"
                    },
                    "analyse-key2": {
                        "name": "Word Frequency"
                    },
                    "analyse-key3": {
                        "name": "Tag Frequency"
                    }
                }
            },
            "sep1": "---------",
            "close": {
                name: "Close",
                icon: function() {
                    return 'context-menu-icon context-menu-icon-quit';
                }
            }
        }
    });
});



// SUPPORT FUNCTIONS

// overview text selection
function wordCloud() {
  // Create an options object for initialization
  var visualdiv = document.getElementById("visualisation-selector");
  var contextItem = document.createElement("canvas");
  contextItem.setAttribute("id", "canvas");
  contextItem.setAttribute("class", "wordcloud");
  contextItem.setAttribute("width", "1448");
  contextItem.setAttribute("height", "940");
  visualdiv.appendChild(contextItem);
  var canvas = document.getElementById("canvas");

  var data = dataset;

  var options = {
    workerUrl: 'Libs/wordfreq/src/wordfreq.worker.js'
  };



  var wordfreq = WordFreq(options).process(data, function (items) {

    var list = items.slice(0, 50);

    console.log(list);

    var highestCount = list[0][1];
    var maxCount = 22;
    //console.log(highestCount);

    for (var i = 0; i < list.length; i++) {
      var currentCount = list[i][1];
      var normalisedCount = currentCount / (highestCount / maxCount);
      list[i][1] = normalisedCount;
    }

    console.log(list);

    WordCloud(canvas, {
      list: list,
          gridSize: Math.round(16 * $('#canvas').width() / 1024),
          weightFactor: function (size) {
            return Math.pow(size, 2.8) * $('#canvas').width() / 1024;
          },
          fontFamily: 'Times, serif',
          color: function (word, weight) {
            return (weight === 12) ? '#f02222' : '#2e2e2e';
          },
          rotateRatio: 0.5,
          rotationSteps: 2,
          backgroundColor: '#e7e7e7'

    });
  });
}



function setDocDownload(){
  var doc = document.getElementById("exportDoc");
  var link = "UserFiles\\Files\\" + docName;
  //console.log(docName);
  //console.log(link);

  doc.href = link;
}


function tagCloud() {
  //Create an options object for initialization
  var visualdiv = document.getElementById("visualisation-selector");
  var contextItem = document.createElement("canvas");
  contextItem.setAttribute("id", "canvas");
  contextItem.setAttribute("class", "wordcloud");
  contextItem.setAttribute("width", "1448");
  contextItem.setAttribute("height", "940");
  visualdiv.appendChild(contextItem);
  var canvas = document.getElementById("canvas");
  var data = dataset;
  var eleArr = [];
  var docTagArray = [];

  $.each(arrayOfAvailableTags, function( key, value ) {
    eleArr.push(key);
  });

  for (var i = 0; i < eleArr.length; i++) {

    var element = "<" + eleArr[i];
    element = element.toLowerCase();

    var n = occurrences(data.toLowerCase(), element, false);

    if (n > 0) {
        element = element.slice(1);
        var tmp = new Array(element, n);
        docTagArray.push(tmp);

    }
  }
  arrayOfDocTags = docTagArray;
  list = docTagArray;

  console.log();

  var lowestCount = list[0][1];
  var maxCount = 22;
  //console.log(highestCount);

  // for (var i = 0; i < list.length; i++) {
  //   var currentCount = list[i][1];
  //   var normalisedCount = currentCount / (highestCount / maxCount);
  //   list[i][1] = normalisedCount;
  // }


  WordCloud(canvas, {
    list: list,
        gridSize: Math.round(16 * $('#canvas').width() / 1024),
        weightFactor: 100,
        // weightFactor: function (size) {
        //   return Math.pow(size, 5) * $('#canvas').width() / 1024;
        // },
        fontFamily: 'Times, serif',
        color: function (word, weight) {
          return (weight === 12) ? '#f02222' : '#2e2e2e';
        },
        rotateRatio: 0.5,
        rotationSteps: 2,
        backgroundColor: '#e7e7e7'

  });


}




/** Function that count occurrences of a substring in a string;
 * @param {String} string               The string
 * @param {String} subString            The sub string to search for
 * @param {Boolean} [allowOverlapping]  Optional. (Default:false)
 *
 * @author Vitim.us https://gist.github.com/victornpb/7736865
 * @see Unit Test https://jsfiddle.net/Victornpb/5axuh96u/
 * @see http://stackoverflow.com/questions/4009756/how-to-count-string-occurrence-in-string/7924240#7924240
 */
function occurrences(string, subString, allowOverlapping) {

    string += "";
    subString += "";
    if (subString.length <= 0) return (string.length + 1);

    var n = 0,
        pos = 0,
        step = allowOverlapping ? 1 : subString.length;

    while (true) {
        pos = string.indexOf(subString, pos);
        if (pos >= 0) {
            ++n;
            pos += step;
        } else break;
    }
    return n;
}


function wordContext(sel){
  var strippedfile = tagStripper(dataset);
  var arrayOfWords = strippedfile.split(" ");
  var arrayOfContext = [];
  var visualdiv = document.getElementById("visualisation-selector");

  arrayOfWords.forEach(function(word){
    if(word.toUpperCase() == sel.toUpperCase()){
      var wordindex = arrayOfWords.indexOf(word);

      var pre = wordindex - 5;
      var splice = arrayOfWords.splice(pre, 9);

      var join = splice.join(" ");

      join = join.replace('\r', ' ').replace('\n', ' ').replace(word, '<b>' + word + '</b>');

      arrayOfContext.push(join);

    }
  });

  arrayOfContext.forEach(function(lst, i, arr) {
      var contextItem = document.createElement("p");
      contextItem.innerHTML = lst
      visualdiv.appendChild(contextItem);
  });

}



function clearVisualisation() {
  var visualdiv = document.getElementById("visualisation-selector");

  while (visualdiv.hasChildNodes()) {
    visualdiv.removeChild(visualdiv.firstChild);
  }
}

function getSelectionText() {
    var text = "";
    if (window.getSelection) {
        text = window.getSelection().toString();
    } else if (document.selection && document.selection.type != "Control") {
        text = document.selection.createRange().text;
    }
    return text;
}

//Count of given values
function getCountOfMarks(value){
  var counter = 0;
  //var marks = $('mark').length;
  $( "mark" ).each(function() {
    if ($(this).text().toUpperCase() === value.toUpperCase()) {
      counter++;
    }
    //console.log( index + ": " + $( this ).text() );
  });

  return counter;
}

function loadFile(file) {
    //var filename = file;
    $.ajax({
        type: "GET",
        url: "ServerFiles/load.php",
        datatype: "xml",
        data: file,
        success: fileLoader,
        fail: function(data) {
            console.log("fail");
            console.log(data);
        }
    });
}

function getAvailableFiles() {
    $.ajax({
        type: "GET",
        url: 'ServerFiles/get_files.php',
        datatype: "json",
        success: fileRenderer,
        fail: function(data) {
            console.log("fail");
            console.log(data);
        }
    });
}

function getAvailableTags() {
    $.ajax({
        type: "GET",
        url: 'ServerFiles/get_tags.php',
        datatype: "json",
        success: function(ev){
          arrayOfAvailableTags = JSON.parse(ev);
        },
        fail: function(data) {
            console.log("fail");
            console.log(data);
        }
    });
}

function getAvailableTagsToRender() {
    $.ajax({
        type: "GET",
        url: 'ServerFiles/get_tags.php',
        datatype: "json",
        success: tagRenderer,
        fail: function(data) {
            console.log("fail");
            console.log(data);
        }
    });
}

function fileLoader(file) {

    //document.location.reload(true);

    dataset = file;

    arrayOfDocTags = getDocumentTags(dataset);

    //var arrayOfTags = getDatasetTags(dataset);
    var strippedfile = tagStripper(dataset);
    //console.log(strippedfile);
    //console.log(arrayOfTags);
    //marking up the background



    var textarea = document.getElementById("document-textarea");
    var title = this.url.split("php?")[1];
    docName = title;

    var noXMLTitle = title.split(".xml")[0];
    textarea.innerHTML = '<pre id="' + noXMLTitle + '" class="formatted-content">' + dataset + "</pre>";

    //var options = {"className": "tagmark"};
    //$(".formatted-content").markRegExp(/>(.*?)<\//ig, options);

}


function parseXMLTags(data){
  var parseXML;
  var xmlStr = data;
  // $xml = $(xmlset);
  // console.log($xml);
  //var tagsArray = [];

  if (window.DOMParser) {
    parseXml = function(xmlStr) {
        return ( new window.DOMParser() ).parseFromString(xmlStr, "text/xml");
    };
  } else if (typeof window.ActiveXObject != "undefined" && new window.ActiveXObject("Microsoft.XMLDOM")) {
      parseXml = function(xmlStr) {
          var xmlDoc = new window.ActiveXObject("Microsoft.XMLDOM");
          xmlDoc.async = "false";
          xmlDoc.loadXML(xmlStr);
          return xmlDoc;
      };
  } else {
      parseXml = function() { return null; }
  }

   return xmlDoc = parseXml(xmlStr);

}



function getDocumentTags(dataset){
  var data = dataset;
  var tags = arrayOfAvailableTags;
  for (var i = 0; i < tags.length; i++) {
    console.log(tags[i]);
  }


  var stringData = toString(data);
  var words = getDatasetWords(data);


  //var xmlDoc = parseXMLTags(data);


  //console.log(tags);
  //console.log(stringData);

  //arrayOfAvailableTags.

  // for (var i = 0; i < array.length; i++) {
  //   array[i]
  // }

  // for (x in arrayOfAvailableTags) {
  //   console.log(x.);
  //   for
  // }

  ///var n = data.includes();


}




function getDatasetWords(dataset){

  var stringData = dataset;
  //console.log(tagsArray);

  //var result = tagsArray.match(/<[^>]*>/g);
  //>(.*?)<\/

  //">myriad</"

  //var result = stringData.match(/>(.*?)<\//g)[0].slice(1, -2);




// [
//   [person, 5],
//   [time, 3]
// ]


  // .map(function(val){
  //    return val.replace(/<\/?b>/g,'');
  // });

  //console.log(tagsArray);

  //var textAsArray = dataset.split(" ");
  //var checkElement = "<";

  //console.log(tagsArray);

  // var result = tagsArray.match(/<b>(.*?)<\/b>/g).map(function(val){
  //    return val.replace(/<\/?b>/g,'');
  // });

  // var interimArray = textAsArray.map(function(el, i, arr) {
  //   if(el.indexOf(checkElement) > -1) {
  //     tagsArray.push(el);
  //     return "";
  //   } else {
  //
  //     return el;
  //   }
  // });

  return true;
  //console.log(result);


}

// function getAvailableTags

function tagStripper(dataset){

  var interimDataset = dataset;

  if ((interimDataset === null) || (interimDataset === '')) {
    return false;
  } else {
    str = interimDataset.toString();
    return str.replace(/<[^>]*>/g, '');
  }

}

function fileRenderer(ev) {
    var data = JSON.parse(ev);
    var filelist = document.getElementById("available-files-list");
    var sellist = document.getElementById("selected-file");
    filelist.innerHTML = "";
    sellist.innerHTML = "";
    data.forEach(function(lst, i, arr) {
        //console.log(lst);
        var listitem = document.createElement("li");
        var listitemlink = document.createElement("a");
        //listitem.setAttribute("id");
        listitemlink.setAttribute("href", "#");
        listitemlink.textContent = lst;
        listitem.appendChild(listitemlink);
        listitem.addEventListener("click", function() {
            sellist.innerHTML = lst;
            //console.log(lst);
        });
        filelist.appendChild(listitem);
    });

}

function tagRenderer(ev) {
    var data = JSON.parse(ev);
    //arrayOfAvailableTags = data;


    var taglist = document.getElementById("tag-elements");
    taglist.innerHTML = "";
    var attrlist = document.getElementById("tag-attributes");
    var attrsel = document.getElementById("selected-attr");
    var attrdropdown = document.getElementById("attribute-selection-dropdown");
    var keys = Object.keys(data);

    keys.forEach(function(el, i, arr) {
        var tag = document.createElement("button");
        tag.setAttribute("type", "button");
        tag.classList.add("list-group-item");
        tag.textContent = el;
        tag.addEventListener("click", function(e) {
            $('#tag-elements *').removeClass('active');
            $('#selected-attr').val("");
            tag.classList.add("active");
            attrlist.innerHTML = "";
            attrdropdown.removeAttribute("disabled");
            data[keys[i]].forEach(function(el, i, arr) {
                var listitem = document.createElement("li");
                var listitemlink = document.createElement("a");
                listitem.setAttribute("id", i);
                listitemlink.setAttribute("href", "#");
                listitemlink.textContent = el;
                var listitemtitle = listitemlink.textContent;
                listitem.appendChild(listitemlink);
                attrlist.appendChild(listitem);

                listitem.addEventListener("click", function() {

                    $("#selected-attr").val(listitemtitle);
                    //console.log(listitemtitle);
                });

            });
        });
        taglist.appendChild(tag);
    });

      taglist.removeChild(taglist.childNodes[0]);
}





//  MESS

// function createArray(length) {
//     var arr = new Array(length || 0),
//         i = length;
//
//     if (arguments.length > 1) {
//         var args = Array.prototype.slice.call(arguments, 1);
//         while(i--) arr[length-1 - i] = createArray.apply(this, args);
//     }
//
//     return arr;
// }

//console.log("key => " + key);//will output: 04c85ccab52880 and all such


// $.each( value, function( ky, val ) {
//     console.log('ky => '+ky);//will output: name, firstname, societe
//     console.log('val => '+val);//will output: name1, fname1, soc1
// });

//var myArray = [[]];

// for (var myArray=[]; myArray.push([])<10;);
//
// console.log(myArray);

// for (var j = 0; j < array.length; j++) {
//   myArray = myArray.push
// }
//
// //docTagArray[i] = docTagArray[i].push([element, n]);
//
// var rows = 8;
// var cols = 7;
//
// // expand to have the correct amount or rows
// for( var j=0; j<eleArr.length; j++ ) {
//   myArray.push( [] );
// }
//
// // expand all rows to have the correct amount of cols
// for (var k = 0; k < rows; k++)
// {
//     for (var l =  myArray[i].length; l < cols; l++)
//     {
//         myArray[k].push(0);
//     }
// }

//docTagArray.push(i);
// docTagArray.push("hi");
// console.log(arrayOfAvailableTags);
// console.log(dictionary);
//
// var docTagArray = $.map(dictionary, function(value, index) {
//
//   return [value];
// });
//
// console.log(docTagArray);


// var count = Object.keys(dictionary).length;
//
// for (var i = 0; i < count; i++) {
//   $.each(dictionary, function( key, value ) {
//     docTagArray[i].push(key, value);
//   });
// }



//console.log(myArray);

//console.log(newArray);

//console.log(arr);

// for (var i = 0; i < arrayOfAvailableTags.length; i++) {
//   console.log(tags);
// }

// WordCloud(canvas, {
//   list: list,
//       gridSize: Math.round(16 * $('#canvas').width() / 1024),
//       weightFactor: function (size) {
//         return Math.pow(size, 2.8) * $('#canvas').width() / 1024;
//       },
//       fontFamily: 'Times, serif',
//       color: function (word, weight) {
//         return (weight === 12) ? '#f02222' : '#2e2e2e';
//       },
//       rotateRatio: 0.5,
//       rotationSteps: 2,
//       backgroundColor: '#e7e7e7'
//
// });



    //console.log("This is " + n);


    //console.log(n);


    // if (!n.trim()) {
    //
    //   //var oldElement = element;
    // }

    // if () {
    //
    // }


    //element = element.slice(1);
    //newArray.push(element);
    //console.log(n);
    //console.log(element);
    //console.log(counter);

// function getSelectionText() {
//     if (window.getSelection) {
//         try {
//             var ta = $('.textarea-content').get(0);
//             var ta = $('#formatted-content').get(0);
//             return ta.value.substring(ta.selectionStart, ta.selectionEnd);
//         } catch (e) {
//             console.log('Cant get selection text')
//         }
//     }
//     // For IE
//     if (document.selection && document.selection.type != "Control") {
//         return document.selection.createRange().text;
//     }
// }

// function uploadFile(){
//   var form_data = new FormData(document.querySelector('form'));
//   alert(form_data);
//   $.ajax({
//       url: 'upload.php', // point to server-side PHP script
//       dataType: 'text', // what to expect back from the PHP script, if anything
//       cache: false,
//       contentType: false,
//       processData: false,
//       data: form_data,
//       type: 'post',
//       success: function(php_script_response) {
//           alert(php_script_response); // display response from the PHP script, if any
//       }
//   });
// }
// function getFiles() {
//     $.ajax({
//         type: "GET",
//         url: 'ServerFiles/getfiles.php',
//         datatype: "json",
//         success: function(data) {
//             return data;
//         }
//     });
// }

// function uploadDocument() {
//   $.ajax({
//     type: "POST",
//     url: 'ServerFiles/upload.php',
//     data: form_data,
//     success: function(data) {
//       //alert(data);
//       console.log(data);
//     }
//   });
// }

//$(".modals").load("modals.php");
// $("#load-modal-button").on("click", function(){
//   list = getFiles();
//   // for(var k in list) {
//   //    console.log(k, list[k]);
//   // }
//   console.log(list);
// });
// $('#upload-file').on('submit', function(e) {
//   e.preventDefault();
//   e.stopPropagation();
//   console.log("hello");
// });

// $('#upload-form').ajaxForm({
// 	url: '../ServerFiles/upload.php',
//   type: 'post'
// });
//
// $("#upload-file").click(function(e) {
//     e.preventDefault();
//     e.stopPropagation();
//     textFunc();
// });

// $("#upload-file").click(function(e) {
//     e.preventDefault();
//     e.stopPropagation();
//     uploadFile();
// });

//$(".overview-content").load("./UserFiles/Files/Chretien.txt");

//   $("#file-load").click(function() {
//     $.ajax({
//         url : "./UserFiles/Files/Chretien.txt",
//         dataType: "text",
//         success : function (data) {
//             $(".overview-content").html(data);
//         }
//     });
// });


//     // Wrap strong tag / 強調タグで囲む
// $('#wrap-strong').click(function(){
//   $('#textarea')
//     // insert before string '<strong>'
//     // <strong> を選択テキストの前に挿入
//     .selection('insert', {text: '<strong>', mode: 'before'})
//     // insert after string '</strong>'
//     // </strong> を選択テキストの後に挿入
//     .selection('insert', {text: '</strong>', mode: 'after'});
// });
//
// // Wrap link tag / リンクタグで囲む
// $('#wrap-link').click(function(){
//   // Get selected text / 選択テキストを取得
//   var selText = $('#textarea').selection();
//
//   $('#textarea')
//     // insert before string '<a href="'
//     // <a href=" を選択テキストの前に挿入
//     .selection('insert', {text: '<a href="', mode: 'before'})
//     // replace selected text by string 'http://'
//     // 選択テキストを http:// に置き換える（http:// を選択状態に）
//     .selection('replace', {text: 'http://'})
//     // insert after string '">SELECTED TEXT</a>'
//     // ">選択テキスト</a> を選択テキストの後に挿入
//     .selection('insert', {text: '">'+ selText + '</a>', mode: 'after'});
// });
//
// // Get selected text / 選択テキストを取得
// $('#sel-textarea').click(function(){
//   // alert selected text
//   // テキストエリアの選択範囲をアラートする
//   alert($('#textarea').selection());
//   $('#textarea').focus();
// });


// $('#upload-file').on('click', function() {
//
// });

/*
$(document).ready(function() {
var form = document.getElementById('upload-form');
var fileSelect = document.getElementById('file-selector');
var uploadButton = document.getElementById('upload-file');

form.onsubmit = function(event) {
  event.preventDefault();

  // Update button text.
  uploadButton.innerHTML = 'Uploading...';

  // The rest of the code will go here...

  // Get the selected files from the input.
  var files = fileSelect.files;

  // Create a new FormData object.
  var formData = new FormData();

  // Loop through each of the selected files.
  // for (var i = 0; i < files.length; i++) {
  //   var file = files[i];

    // Check the file type.
    if (!file.type.match('text/plain')) {
      continue;
    }

    // Add the file to the request.
    formData.append('file-selector', file, file.name);
  //}

  // Set up the request.
  var xhr = new XMLHttpRequest();

  // Open the connection.
  xhr.open('POST', 'upload.php', true);

  // Set up a handler for when the request finishes.
  xhr.onload = function () {
    if (xhr.status === 200) {
      // File(s) uploaded.
      uploadButton.innerHTML = 'Uploaded';
    } else {
      alert('An error occurred!');
    }
  };

  // Send the Data.
  xhr.send(formData);

}
});



$('#upload-file').on('click', function() {
    var file_data = $('#sortpicture').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    alert(form_data);
    $.ajax({
                url: 'upload.php', // point to server-side PHP script
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(php_script_response){
                    alert(php_script_response); // display response from the PHP script, if any
                }
     });
});



$("#file-load").click(function(){
    $(".overview-content").load("../UserFiles/Files/Chretien 1 Eric.txt", function(responseTxt, statusTxt, xhr){
        if(statusTxt == "success")
            alert("External content loaded successfully!");
        if(statusTxt == "error")
            alert("Error: " + xhr.status + ": " + xhr.statusText);
    });
});



// RIGHT CLICK MENU
$(function() {
        $.contextMenu({
            selector: '.right-click-menu',
            callback: function(key, options) {
                var m = "clicked: " + key;
                window.console && console.log(m) || alert(m);
            },
            items: {
                "assign-tags": {
                  name: "Assign Tags",
                  callback: function(key, options) {
                    $("#assign-tag-modal").modal()
                  }
                },
                "analyse": {
                "name": "Analyse",
                "items": {
                    "analyse-key1": {"name": "Word Context"},
                    "analyse-key2": {"name": "Word Frequency"},
                    "analyse-key3": {"name": "Tag Frequency"}
                }
            },
                "sep1": "---------",
                "close": {name: "Close", icon: function(){
                    return 'context-menu-icon context-menu-icon-quit';
                }}
            }
        });
    });






























  // SUCCESSFUL UPLOAD
  // function uploadSuccess(){
  //        $("#dialog").html("Hi");
  //        $("#dialog").dialog({
  //            title: "jQuery Dialog Popup",
  //            buttons: {
  //                Close: function () {
  //                    $(this).dialog('close');
  //                }
  //            },
  //            modal: true
  //        });
  // }

  // Variable to store your files
  var files;

  // Add events
  $("input[type=file]").on("change", prepareUpload);

  // Grab the files and set them to our variable
  function prepareUpload(event) {
    files = event.target.files;
  }

  $("upload-form").on("submit", uploadFiles);




// Catch the form submit and upload the files
function uploadFiles(event) {
  event.stopPropagation(); // Stop stuff happening
    event.preventDefault(); // Totally stop stuff happening

    // START A LOADING SPINNER HERE

    // Create a formdata object and add the files
    var data = new FormData();
    $.each(files, function(key, value) {
        data.append(key, value);
    });

    $.ajax({
        url: "ServerFiles/upload.php?files",
        type: "POST",
        data: data,
        cache: false,
        dataType: "json",
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        success: function(data, textStatus, jqXHR) {
            if(typeof data.error === "undefined") {
                // Success so call function to process the form
                submitForm(event, data);
            } else {
                // Handle errors here
                console.log('ERRORS: ' + data.error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Handle errors here
            console.log('ERRORS: ' + textStatus);
            // STOP LOADING SPINNER
        }
    });
}

function submitForm(event, data) {
  // Create a jQuery object from the form
    $form = $(event.target);

    // Serialize the form data
    var formData = $form.serialize();

    // You should sterilise the file names
    $.each(data.files, function(key, value)
    {
        formData = formData + '&filenames[]=' + value;
    });

    $.ajax({
        url: 'upload.php',
        type: 'POST',
        data: formData,
        cache: false,
        dataType: 'json',
        success: function(data, textStatus, jqXHR)
        {
            if(typeof data.error === 'undefined')
            {
                // Success so call function to process the form
                console.log('SUCCESS: ' + data.success);
            }
            else
            {
                // Handle errors here
                console.log('ERRORS: ' + data.error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Handle errors here
            console.log('ERRORS: ' + textStatus);
        },
        complete: function()
        {
            // STOP LOADING SPINNER

        }
    });
}
*/
