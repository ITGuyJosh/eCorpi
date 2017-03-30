// GLOBALS
var dataset = "";

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
          var selFilename = $(".formatted-content").attr("id");
          var text = dataset;
          var searchTerm = $("#selected-word").val();
          var selElement = $(".active").html();
          var selAttribute = $("#selected-attr").val();
          var selValue = $("#new-value").val();

          var updatedXML = addTagToXML(text, searchTerm, selElement, selAttribute, selValue);

          dataset = updatedXML;

          //console.log(updatedXML);

          formData.push(
            {name: 'updatedXML',value: updatedXML}
        );
        },
        success: function() {
            $("#assign-tag-modal").delay(1000).fadeOut('slow');
            setTimeout(function() {
                $("#assign-tag-modal").modal('hide');
            }, 1500);

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
            var m = "Clicked on " + key + " on element " + sel;
            //window.console && console.log(m) || alert(m);
        },
        items: {
            "assign-tags": {
                name: "Assign Tags",
                callback: function(key, options) {
                    var sel = getSelectionText();
                    getAvailableTags();
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

function loadFile(file) {
    //var filename = file;
    $.ajax({
        type: "GET",
        url: "ServerFiles/parse.php",
        datatype: "string",
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
        url: 'ServerFiles/getfiles.php',
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
        url: 'ServerFiles/xml.php',
        datatype: "json",
        success: tagRenderer,
        fail: function(data) {
            console.log("fail");
            console.log(data);
        }
    });
}

function fileLoader(file) {
    dataset = file;
    console.log(dataset);
    var textarea = document.getElementById("document-textarea");
    var title = this.url.split("php?")[1];
    var noXMLTitle = title.split(".xml")[0];
    textarea.innerHTML = '<pre id="' + noXMLTitle + '" class="formatted-content">' + file + "</pre>";
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
