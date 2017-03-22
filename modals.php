<!-- LOAD MODAL -->
<div class="modal fade" id="load-modal" tabindex="-1" role="dialog" aria-labelledby="load-modal-label">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="load-modal-label">Load Document</h4>
            </div>
            <div class="modal-body">

                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="load-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
          Select document...
          <span class="caret"></span>
        </button>
                    <ul class="dropdown-menu" aria-labelledby="load-dropdown">
                        <li><a href="#">Doc 1</a></li>
                        <li><a href="#">Doc 2</a></li>
                        <li><a href="#">Doc 3</a></li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="file-load">Load</button>
            </div>
        </div>
    </div>
</div>

<!-- UPLOAD MODAL -->

<div class="modal fade" id="upload-modal" tabindex="-1" role="dialog" aria-labelledby="upload-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="upload-modal-label">Upload Document</h4>
            </div>

            <!-- <form method="post" enctype="multipart/form-data" id="upload-form"> -->
            <form method="post" enctype="multipart/form-data" id="upload-form" action="ServerFiles/upload.php">

            <div class="modal-body">

                    <div class="form-group upload-form">
                        <label class="btn btn-primary" for="file-selector">
          <input name="file-selector" id="file-selector" type="file" style="display:none;" onchange="$('#upload-file-info').html($(this).val());">
          Select file...
      </label>
                        <span class='label label-info' id="upload-file-info"></span>
                        <div class="upload-form-meta">
                            <h5>Optional Meta Data</h5>
                            <input type="text" class="form-control" placeholder="Author..." aria-describedby="author-text" name="file-meta-author">
                            <input type="text" class="form-control" placeholder="Title..." aria-describedby="title-text" name="file-meta-title">
                            <input type="text" class="form-control" placeholder="Genre..." aria-describedby="genre-text" name="file-meta-genre">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-default" id="upload-file" name="submit" value="Upload" />
            </div>

            </form>
        </div>
    </div>
</div>

<!-- TAGS MODAL -->

<div class="modal fade" id="tag-modal" tabindex="-1" role="dialog" aria-labelledby="tags-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="upload-modal-label">Tag Management</h4>
            </div>
            <div class="modal-body">

                <div class="row schema-tags">
                    <div class="col-md-4 available-tags">
                        <h5>Available Tags</h5>
                        <div class="list-group">
                            <button type="button" class="list-group-item">Tag 1</button>
                            <button type="button" class="list-group-item">Tag 2</button>
                            <button type="button" class="list-group-item">Tag 3</button>
                            <button type="button" class="list-group-item">Tag 4</button>
                            <button type="button" class="list-group-item">Tag 5</button>
                        </div>

                    </div>

                    <div class="col-md-8">

                        <form>
                            <div class="form-group">
                                <div class="tags-form">
                                    <h5>Modify</h5>
                                    <input type="text" class="form-control" placeholder="Element..." id="tag-element">

                                    <div class="input-group tag-input-groups">
                                        <input type="text" class="form-control" placeholder="Attribute..." id="tag-attribute">
                                        <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-remove" id="remove-attribute"></span></button>
                                        </span>
                                    </div>
                                    <div class="container-fluid tag-values">
                                        <div class="row-fluid">
                                            <div class="col-md-2">
                                                <div class="add-field">
                                                    <span class="glyphicon glyphicon-plus" id="add-value"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="input-group tag-input-groups">
                                                    <input type="text" class="form-control" placeholder="Value..." id="tag-value">
                                                    <span class="input-group-btn">
                                                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-remove" id="remove-value"></span></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="add-field">
                                        <span class="glyphicon glyphicon-plus" id="add-value"></span>
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left">New</button>
                    <button type="button" class="btn btn-danger outline">Delete</button>
                    <button type="button" class="btn btn-default">Cancel</button>
                    <button type="button" class="btn btn-default">Save</button>
                </div>


            </div>

        </div>
    </div>
</div>

<!-- EXPORT MODAL -->

<div class="modal fade" id="export-modal" tabindex="-1" role="dialog" aria-labelledby="export-modal-label">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="export-modal-label">Export File</h4>
            </div>
            <div class="modal-body">

                <h5>Select a file to download.</h5>
                <div class="list-group export-links">
                    <a href="#" class="list-group-item">Document metadata<span class="glyphicon glyphicon-circle-arrow-down"></span></a>
                    <a href="#" class="list-group-item">Visualisation extract<span class="glyphicon glyphicon-circle-arrow-down"></span></a>
                    <a href="#" class="list-group-item">System schema<span class="glyphicon glyphicon-circle-arrow-down"></span></a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ASSIGN MODAL -->

<div class="modal fade" id="assign-tag-modal" tabindex="-1" role="dialog" aria-labelledby="assign-tag-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="upload-modal-label">Tag Assignment</h4>
            </div>
            <div class="modal-body">

              <div class="input-group">
                <span class="input-group-addon">Selection</span>
                <input type="text" class="form-control" id="selected-word" readonly name="selection">
              </div>
                <div class="row schema-tags">
                    <div class="col-md-4 available-tags">
                        <h5>Available Tags</h5>
                        <div class="list-group" id="tag-elements">

                            <!-- <button type="button" class="list-group-item">Tag 1</button>
                            <button type="button" class="list-group-item">Tag 2</button>
                            <button type="button" class="list-group-item">Tag 3</button>
                            <button type="button" class="list-group-item">Tag 4</button>
                            <button type="button" class="list-group-item">Tag 5</button> -->
                        </div>

                    </div>

                    <div class="col-md-8">

                        <form>
                            <div class="form-group">
                                <div class="tags-form">
                                    <h5>Assign Tag</h5>
                                    <div class="input-group available-tags-input-groups">
                                        <div class="dropdown assign-tag-dropdown">
                                            <button class="btn btn-default dropdown-toggle" type="button" id="attribute-selection-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" disabled>
                              Attribute...
                              <span class="caret"></span>
                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="attribute-selection-dropdown" id="tag-attributes">
                                                <!-- <li><a href="#">Attribute 1</a></li>
                                                <li><a href="#">Attribute 2</a></li>
                                                <li><a href="#">Attribute 3</a></li> -->
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="input-group available-tags-input-groups">
                                        <div class="dropdown assign-tag-dropdown">
                                            <button class="btn btn-default dropdown-toggle" type="button" id="value-selection-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                              Value...
                              <span class="caret"></span>
                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="value-selection-dropdown">
                                                <li><a href="#">Value 1</a></li>
                                                <li><a href="#">Value 2</a></li>
                                                <li><a href="#">Value 3</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="New value..." aria-describedby="author-text" id="new-value">
                                </div>

                            </div>
                        </form>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default">Assign</button>
                    <button type="button" class="btn btn-default">Assign All</button>
                </div>


            </div>

        </div>
    </div>
</div>

<!-- UPLOAD COMPLETE MODAL -->

<div class="modal fade" id="upload-complete-modal" tabindex="-1" role="dialog" aria-labelledby="upload-complete-modal-label">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <!-- <h4 class="modal-title" id="upload-complete-modal-label">Export File</h4> -->
            </div>
            <div class="modal-body">

                <h2>Upload Successful</h2>

            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
 //http://stackoverflow.com/questions/1960240/jquery-ajax-submit-form
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
      this.reset();
      }
    });



    //$("#assign-tag-modal").ajaxSubmit({url: 'ServerFiles/xml.php', type: 'get'})
</script>


<script>
/*
$.ajax({
    //This will retrieve the contents of the folder if the folder is configured as 'browsable'
    url: 'UserFiles/Files/',
    success: function (data) {
        console.log(data);
       $(".dropdown-menu").html('<ul>');
       //List all xml file names in the page

        //var filename = this.href.replace(window.location, "").replace("http:///", "");
       //$("#fileNames").append( '<li>'+filename+'</li>');

        $(data).find("a:contains(" + fileExt + ")").each(function () {
            $(".dropdown-menu").append( '<li>'+$(this).text()+'</li>');
        });
        $(".dropdown-menu").append('</ul>');
    }
});

});

$(window).load(function(){
   var fileExt = ".txt";

        $(document).ready(function(){

            $.ajax({
                //This will retrieve the contents of the folder if the folder is configured as 'browsable'
                url: 'UserFiles/Files/',
                success: function (data) {
                    console.log(data);
                   $(".dropdown-menu").html('<ul>');
                   //List all xml file names in the page

                    //var filename = this.href.replace(window.location, "").replace("http:///", "");
                   //$("#fileNames").append( '<li>'+filename+'</li>');

                    $(data).find("a:contains(" + fileExt + ")").each(function () {
                        $(".dropdown-menu").append( '<li>'+$(this).text()+'</li>');
                    });
                    $(".dropdown-menu").append('</ul>');
                }
            });

        });
});
*/
</script>
