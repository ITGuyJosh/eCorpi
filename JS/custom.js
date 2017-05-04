// GLOBALS
var dataset = "";
var arrayOfAvailableTags = [
    []
];
var arrayOfDocTags = [
    []
];
var docName;

//ON DOC READY
$(document).ready(function() {

  //TRACKING FOR TESTING
  //Hotjar Tracking Code for https://1525770.linux.studentwebserver.co.uk/eCorp
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:466433,hjsv:5};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');


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


    // load doc handler
    $("#load-modal-button").on("click", function() {
        getAvailableFiles();
    });

    //downloads
    $("#export-modal-button").on("click", function() {

        var doc = document.getElementById("exportDoc");
        var visual = document.getElementById("exportVisual");
        var schema = document.getElementById("exportSchema");
        var canvas = document.getElementById("canvas");

        doc.onclick = function() {
            if (docName != null) {
                var link = "UserFiles\\Files\\" + docName;
                doc.href = link;
                doc.setAttribute("download", docName);
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

            if (canvas != null) {

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


        schema.onclick = function() {

            var link = "schema.xsd";
            schema.href = link;
            schema.setAttribute("download", link);
            schema.click();
            successDownload();
        }

    });


    //file loading and validation
    $("#file-load").on("click", function() {
        //get element
        var file = $("#selected-file").html();
        //check if selected
        if (file == "") {
            $("#negative-alert").html("<strong>Please select a document!</strong>");
            $("#negative-alert").fadeIn("slow", function() {
                setTimeout(function() {
                    $("#negative-alert").fadeOut("slow");
                }, 2000);
            });
        } else {
            //clear visual pane
            clearVisualisation();
            //load selected file
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
        //server processing
        url: 'ServerFiles/upload.php',
        type: 'post',
        beforeSubmit: function() {
            //get values
            var file = document.getElementById("file-selector").value;
            var author = document.getElementById("file-meta-author").value;
            var title = document.getElementById("file-meta-title").value;
            var type = document.getElementById("file-meta-genre").value;
            var mime = file.substring(file.length - 4, file.length);

            if (file.trim() == "" || author.trim() == "" || title.trim() == "" || type.trim() == "") {
                $("#negative-alert").html("<strong>Please select a document and enter all meta data!</strong>");
                $("#negative-alert").fadeIn("slow", function() {
                    setTimeout(function() {
                        $("#negative-alert").fadeOut("slow");
                    }, 2000);
                });
                return false;
            }
            if (mime != ".txt") {
                $("#negative-alert").html("<strong>Please ensure your file is a '.txt' document!</strong>");
                $("#negative-alert").fadeIn("slow", function() {
                    setTimeout(function() {
                        $("#negative-alert").fadeOut("slow");
                    }, 2000);
                });

                return false;
            }

        },
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
        beforeSubmit: function(formData, formObject, formOptions) {
            var filename = $(".formatted-content").attr("id");
            var text = dataset;
            var searchTerm = $("#selected-word").val();
            var selElement = $(".active").html();
            var selAttribute = $("#selected-attr").val();
            var selValue = $("#new-value").val();



            if (searchTerm.trim() == "") {
                $("#negative-alert").html("<strong>Please select a search term by highlighting and right clicking a word to assign!</strong>");
                $("#negative-alert").fadeIn("slow", function() {
                    setTimeout(function() {
                        $("#negative-alert").fadeOut("slow");
                    }, 2000);
                });

                return false;
            }


            if (selAttribute.trim() == "") {
                $("#negative-alert").html("<strong>Please select an attribute by first clicking on an element!</strong>");
                $("#negative-alert").fadeIn("slow", function() {
                    setTimeout(function() {
                        $("#negative-alert").fadeOut("slow");
                    }, 2000);
                });

                return false;
            }

            if (selValue.trim() == "") {
                $("#negative-alert").html("<strong>Please enter a value!</strong>");
                $("#negative-alert").fadeIn("slow", function() {
                    setTimeout(function() {
                        $("#negative-alert").fadeOut("slow");
                    }, 2000);
                });

                return false;
            }


            var updatedXML = addTagToXML(text, searchTerm, selElement, selAttribute, selValue);

            dataset = updatedXML;

            //console.log(updatedXML);

            formData.push({
                name: 'updatedXML',
                value: updatedXML
            }, {
                name: 'filename',
                value: filename
            });

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

 //assigning tags to xml doc
function addTagToXML(text, searchTerm, selElement, selAttribute, selValue) {
    //splitting text by spaces into array & checking for element already existing
    var textAsArray = text.split(" ");
    var checkElement = "<" + selElement;
    var interimArray = textAsArray.map(function(el, i, arr) {
        if (el.indexOf(checkElement) > -1) {
            return "";
        } else {
            return el;
        }
    });
    //add searchTerm to matching element in document
    var interimArray2 = interimArray.map(function(el, i, arr) {
        if (el === searchTerm) {
            var element = document.createElement(selElement);
            var attr1 = element.setAttribute(selAttribute, selValue);
            element.textContent = el;
            return element.outerHTML;
        } else {
            return el;
        }
    });
    //generate output
    var output = interimArray2.map(function(el, i, arr) {
        if (el == "") {
            return textAsArray[i];
        } else {
            return el;
        }
    });
    //join words
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


// generate wordcloud from text
function wordCloud() {
    //create an options object for initialization
    var visualdiv = document.getElementById("visualisation-selector");
    var contextItem = document.createElement("canvas");
    contextItem.setAttribute("id", "canvas");
    contextItem.setAttribute("class", "wordcloud");
    contextItem.setAttribute("width", "1448");
    contextItem.setAttribute("height", "940");
    visualdiv.appendChild(contextItem);
    var canvas = document.getElementById("canvas");
    //strip tags & run worker
    var data = tagStripper(dataset);
    var options = {
        workerUrl: 'Libs/wordfreq/src/wordfreq.worker.js'
    };
    //set wordfreq options
    var wordfreq = WordFreq(options).process(data, function(items) {
        //normalise for large list
        if (items.length > 20) {
            var list = items.slice(0, 50);
            var highestCount = list[0][1];
            var maxCount = 22;
            for (var i = 0; i < list.length; i++) {
                var currentCount = list[i][1];
                var normalisedCount = currentCount / (highestCount / maxCount);
                list[i][1] = normalisedCount;
            }
            //setup canvas
            WordCloud(canvas, {
                list: list,
                gridSize: Math.round(16 * $('#canvas').width() / 1024),
                weightFactor: function(size) {
                    return Math.pow(size, 2.8) * $('#canvas').width() / 1024;
                },
                fontFamily: 'Times, serif',
                color: function(word, weight) {
                    return (weight === 12) ? '#f02222' : '#2e2e2e';
                },
                rotateRatio: 0.5,
                rotationSteps: 2,
                backgroundColor: '#e7e7e7'
            });
        } else {
            clearVisualisation();
            $("#negative-alert").html("<strong>Please select a document with more words!</strong>");
            $("#negative-alert").fadeIn("slow", function() {
                setTimeout(function() {
                    $("#negative-alert").fadeOut("slow");
                }, 2000);
            });

            return;
        }

    });
}



function setDocDownload() {
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

    $.each(arrayOfAvailableTags, function(key, value) {
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

    WordCloud(canvas, {
        list: list,
        gridSize: Math.round(16 * $('#canvas').width() / 1024),
        weightFactor: 75,
        // weightFactor: function (size) {
        //   return Math.pow(size, 5) * $('#canvas').width() / 1024;
        // },
        fontFamily: 'Times, serif',
        color: function(word, weight) {
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


//get context of selected word against whole text
function wordContext(sel) {
    //strip dataset and get individual words
    var strippedfile = tagStripper(dataset);
    var arrayOfWords = strippedfile.split(" ");
    var arrayOfContext = [];
    var visualdiv = document.getElementById("visualisation-selector");
    //loop through words to find instances & add them to a new context array
    arrayOfWords.forEach(function(word) {
        if (word.toUpperCase() == sel.toUpperCase()) {
            var wordindex = arrayOfWords.indexOf(word);
            var pre = wordindex - 5;
            var splice = arrayOfWords.splice(pre, 9);
            var join = splice.join(" ");
            join = join.replace('\r', ' ').replace('\n', ' ').replace(word, '<b>' + word + '</b>');
            arrayOfContext.push(join);
        }
    });
    //append content of context array onto page
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
function getCountOfMarks(value) {
    var counter = 0;
    //var marks = $('mark').length;
    $("mark").each(function() {
        if ($(this).text().toUpperCase() === value.toUpperCase()) {
            counter++;
        }
    });

    return counter;
}

//load passed file
function loadFile(file) {
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
        success: function(ev) {
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
    //apply file to global
    dataset = file;

    //generate array of the files tags
    arrayOfDocTags = getDocumentTags(dataset);

    //set document title
    var textarea = document.getElementById("document-textarea");
    var title = this.url.split("php?")[1];
    docName = title;

    //remove mime type
    var noXMLTitle = title.split(".xml")[0];

    //load in doc to pre
    textarea.innerHTML = '<pre id="' + noXMLTitle + '" class="formatted-content">' + dataset + "</pre>";
}


function parseXMLTags(data) {
    var parseXML;
    var xmlStr = data;

    if (window.DOMParser) {
        parseXml = function(xmlStr) {
            return (new window.DOMParser()).parseFromString(xmlStr, "text/xml");
        };
    } else if (typeof window.ActiveXObject != "undefined" && new window.ActiveXObject("Microsoft.XMLDOM")) {
        parseXml = function(xmlStr) {
            var xmlDoc = new window.ActiveXObject("Microsoft.XMLDOM");
            xmlDoc.async = "false";
            xmlDoc.loadXML(xmlStr);
            return xmlDoc;
        };
    } else {
        parseXml = function() {
            return null;
        }
    }
    return xmlDoc = parseXml(xmlStr);
}



function getDocumentTags(dataset) {
    var data = dataset;
    var tags = arrayOfAvailableTags;
    for (var i = 0; i < tags.length; i++) {
        console.log(tags[i]);
    }
    var stringData = toString(data);
    var words = getDatasetWords(data);
}




function getDatasetWords(dataset) {
    var stringData = dataset;
    return true;
}


function tagStripper(dataset) {

    var interimDataset = dataset;

    if ((interimDataset === null) || (interimDataset === '')) {
        return false;
    } else {
        str = interimDataset.toString();
        return str.replace(/<[^>]*>/g, '');
    }
}

//render server docs as html elements
function fileRenderer(ev) {
    //parse json data & set vars
    var data = JSON.parse(ev);
    var filelist = document.getElementById("available-files-list");
    var sellist = document.getElementById("selected-file");
    filelist.innerHTML = "";
    sellist.innerHTML = "";
    //loop through docs and append elements
    data.forEach(function(lst, i, arr) {
        var listitem = document.createElement("li");
        var listitemlink = document.createElement("a");
        listitemlink.setAttribute("href", "#");
        listitemlink.textContent = lst;
        listitem.appendChild(listitemlink);
        listitem.addEventListener("click", function() {
            sellist.innerHTML = lst;
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
