<!DOCTYPE html>
<html lang="en">

<head>
    <!-- META INFORMATION -->
    <title>Visualisation Tool</title>
    <meta name="Description" content="A tag based Data Visualisation Tool for the Digital Humanities that incorcoporates Text Analysis to discover insight surrounding entities within historical documents. Designed for the University of Chester in 2016-17 by Joshua Evans."
    />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


    <!-- STYLING -->
    <link href="Libs/bootstrap/css/bootstrap.css" rel="stylesheet" />
    <link href="Libs/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet"/>
    <link href="Libs/jquery-ui-1.12.1/jquery-ui.structure.min.css" rel="stylesheet"/>
    <link href="Libs/jquery-ui-1.12.1/jquery-ui.theme.min.css" rel="stylesheet"/>
    <link href="Libs/jquery-contextMenu/dist/jquery.contextMenu.min.css" rel="stylesheet"/>
    <!-- <link href="Libs/jquery.highlighttext/jquery.highlighttextarea.min.css" rel="stylesheet"/> -->
    <link href="CSS/custom.css" rel="stylesheet" title="custom" />

    <!-- SCRIPTS -->
    <script src="Libs/jquery-3.1.1.js"></script>
    <script src="Libs/bootstrap/js/bootstrap.js"></script>
    <script src="Libs/jquery-ui-1.12.1/jquery-ui.min.js"></script>
    <script src="Libs/jquery-contextMenu/dist/jquery.contextMenu.min.js"></script>
    <script src="Libs/jquery-contextMenu/dist/jquery.ui.position.min.js"></script>
    <script src="Libs/wordfreq/src/wordfreq.js"></script>
    <script src="Libs/wordcloud2/src/wordcloud2.js"></script>
    <!-- <script src="Libs/jquery.highlighttextarea/jquery.highlighttextarea.min.js"></script> -->
    <script src="Libs/jquery.selection/src/jquery.selection.js"></script>
    <script src="Libs/jquery.form/src/jquery.form.js"></script>
    <script src="JS/custom.js"></script>
</head>

<body>

    <!-- HEADER -->
    <header>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">

                <!-- Brand and toggle get grouped for better mobile display -->
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#my-navbar">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">University of Chester</a>
                </div>
                <div class="collapse navbar-collapse" id="my-navbar" />
                <ul class="nav navbar-nav navbar-right">
                    <li id="load-modal-button" data-toggle="modal" data-target="#load-modal"><a href="#">Load</a></li>
                    <li data-toggle="modal" data-target="#upload-modal"><a href="#">Upload</a></li>
                    <li data-toggle="modal" data-target="#tag-modal"><a href="#">Tags</a></li>
                    <li data-toggle="modal" data-target="#export-modal"><a href="#">Export</a></li>
                </ul>
            </div>
            </div>
            </div>
        </nav>
    </header>


    <!-- MODALS -->
    <!-- <div class="modals"></div> -->
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

    <!-- MAIN INTERFACE -->
    <section>
        <div class="container-fluid fill custom-main-interface">

          <!-- <span id="message-popup"></span> -->
          <div id="positive-alert" class="alert alert-success" role="alert"></div>
          <div id="negative-alert" class="alert alert-danger" role="alert"></div>

            <div class="row fill">

                <!-- OVERVIEW -->

                <div class="col-md-5 fill custom-overview-pane">
                    <div class="overview-pane">

                        <div class="input-group search-bar">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                          <button class="btn btn-default" type="button">
                            <span class="glyphicon glyphicon-search"></span>
                            </button>
                            </span>
                        </div>

                        <!-- <div class="overview-content" oncontextmenu="return false;"> -->
                        <div class="overview-content" oncontextmenu="return false;">

                        <?php  //$xmlDoc = new DOMDocument();$xmlDoc->load('/Applications/XAMPP/xamppfiles/htdocs/eCorpi/UserFiles/Files/Chretien 1 Erec.xml');?>
                        <?PHP  echo '<textarea class="textarea-content right-click-menu" placeholder="Please load in a document for analysis..." readonly>', strip_tags(file_get_contents('/Applications/XAMPP/xamppfiles/htdocs/eCorpi/UserFiles/Files/Chretien 1 Erec.xml')), '</textarea>'; ?>
                        <?PHP //echo '<pre>', strip_tags(file_get_contents('/Applications/XAMPP/xamppfiles/htdocs/eCorpi/UserFiles/Files/Chretien 1 Erec.xml')), '</pre>'; ?>
                        <?php // echo nl2br( htmlspecialchars( file_get_contents('/Applications/XAMPP/xamppfiles/htdocs/eCorpi/UserFiles/Files/Chretien 1 Erec.xml'))); ?>
                        <?php //include('/Applications/XAMPP/xamppfiles/htdocs/eCorpi/UserFiles/Files/Chretien 1 Erec.txt'); ?>


                            <!--<p><span class="right-click-menu">Lorem</span> ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ac auctor dolor, non imperdiet sem. Aenean vel ligula semper, aliquam nisi id, semper lectus. Nullam ac sapien vitae ante facilisis mattis. Sed nec vehicula
                                augue. Quisque in lacus quis eros consectetur auctor. Suspendisse tincidunt in urna eget dictum. Vivamus accumsan mauris ut augue consectetur semper.</p>

                            <p>Nam varius tempor libero, quis consectetur tortor pharetra quis. Integer cursus placerat lectus a faucibus. Curabitur imperdiet aliquet convallis. Maecenas tincidunt a diam in porta. Pellentesque euismod iaculis sagittis. Aliquam
                                finibus vel mauris at elementum. Donec eleifend mattis orci, vitae convallis libero cursus et.</p>

                            <p>Aenean aliquam eget eros et scelerisque. Etiam in semper justo. Ut interdum mi sit amet velit tincidunt, sed congue justo aliquet. Aenean eu ipsum id ex lobortis accumsan in nec leo. Donec at enim elementum, pharetra nunc sit
                                amet, tincidunt turpis. Integer accumsan diam nec cursus posuere. Nam eget tempor ligula. Phasellus pulvinar in est ac scelerisque.</p>

                            <p>Aenean nec maximus leo. Sed semper leo turpis, et scelerisque enim sollicitudin at. Vestibulum imperdiet ut neque vel dignissim. Duis molestie luctus justo, ultrices dapibus dolor pretium laoreet. Aliquam vitae magna tellus.
                                Donec laoreet ipsum lacus, a vulputate eros egestas eget. Ut at diam eget sem ultrices facilisis. Duis ultricies quam at lectus dapibus, ac rhoncus turpis finibus. Donec sit amet sodales nulla.</p>

                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed at sem suscipit, eleifend tortor sed, dignissim risus. Morbi at porta nisi. Cum sociis natoque penatibus et magnis dis parturient
                                montes, nascetur ridiculus mus. Curabitur vitae nulla ornare, volutpat lacus non, aliquam lacus. Vestibulum sit amet blandit odio. Vivamus tristique urna feugiat, dapibus purus a, rutrum nisi. In a scelerisque lacus. Nam
                                eu dapibus odio. Nunc sit amet interdum est. Proin lobortis, leo imperdiet mollis auctor, augue arcu consequat arcu, sed elementum enim nunc vel mauris. Quisque nibh risus, semper id malesuada id, convallis id nulla. Duis
                                elementum est in leo tempus, eu ullamcorper odio scelerisque. Quisque euismod magna erat, in rutrum enim lobortis ut.</p>

                            <p>Cras mattis porta lacus nec convallis. Duis ut ante sit amet urna sodales ultricies. Ut sagittis sit amet nunc non sollicitudin. Nam ac quam ac ipsum efficitur ultrices. Quisque sed placerat tellus. Mauris ut enim orci. Etiam
                                ultrices, tortor nec hendrerit lacinia, metus erat iaculis justo, viverra pretium eros odio et arcu. Aenean congue aliquam nunc, scelerisque egestas lacus mollis non. Nunc ut sapien est. Ut bibendum tempor odio eget venenatis.
                                Maecenas vitae nisl magna. Proin dictum mauris sed nunc molestie sollicitudin. Aliquam pharetra dapibus est quis facilisis. Nullam ut vulputate eros.</p>

                            <p>Duis at nunc scelerisque, lobortis est a, vulputate orci. Duis aliquam ultricies tempor. Donec id massa rutrum, rhoncus mauris vel, ultrices tortor. Fusce id dui elit. Mauris ut enim pharetra, dignissim odio eu, luctus metus.
                                Aliquam fringilla volutpat turpis eget accumsan. Fusce a mattis odio, ac tempus risus. Sed suscipit lectus neque, ut rutrum libero varius sed. Duis vitae auctor dolor, sed elementum dui.</p>

                            <p>Praesent eu nibh nec nisi porttitor posuere at nec ex. Etiam justo enim, malesuada nec accumsan id, aliquam non arcu. Donec placerat tincidunt lorem. Ut semper dignissim odio, ac varius augue sollicitudin sit amet. Nam accumsan
                                augue ut eros feugiat, id rutrum quam placerat. Cras at dolor fringilla, ullamcorper dolor eu, pharetra nibh. Mauris maximus purus eget tincidunt fermentum. Nam bibendum quam lorem, at iaculis tellus viverra vitae. Vivamus
                                euismod libero et lectus imperdiet venenatis sed eget nulla.</p>

                            <p>Morbi at rhoncus ligula. Integer eget dapibus dolor. Duis eget orci nec leo sagittis fermentum quis id purus. Aenean vel libero at enim hendrerit euismod. Aenean ornare ex velit, sit amet ultrices felis fringilla egestas. In
                                hac habitasse platea dictumst. Nam maximus, mauris accumsan rutrum sollicitudin, magna massa lobortis augue, a efficitur nulla metus ac nisl.</p>

                            <p>Donec porttitor est et aliquam imperdiet. In pharetra non risus non mollis. Aliquam efficitur euismod volutpat. Sed ullamcorper nisi eros, non laoreet sem dignissim ac. Maecenas tincidunt consectetur tellus non volutpat. Quisque
                                ullamcorper auctor ligula, quis maximus risus consectetur a. Sed tempor laoreet pharetra. In dignissim ligula vitae rutrum cursus. Donec sagittis, tortor non congue eleifend, lectus quam interdum tortor, eu fringilla purus
                                nisi sit amet eros. Suspendisse condimentum, ex non commodo semper, odio metus lobortis sem, nec ultrices nibh elit nec quam. Cras mattis auctor risus. Praesent tempus sem convallis nibh suscipit, sed varius dolor convallis.
                                Aliquam venenatis lorem vitae ipsum imperdiet suscipit. Mauris at condimentum massa. Phasellus eget metus volutpat, sollicitudin est quis, fermentum arcu. Curabitur consequat arcu dolor.</p>
 -->

                        </div>

                    </div>
                </div>



                <!-- VISUALISATION -->

                <div class="col-md-7 fill custom-visualisation-pane">
                    <div class="visualisation-pane">

                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                              Select visualisation...
                              <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a href="#">Word Cloud</a></li>
                                <li><a href="#">Word Tree</a></li>
                            </ul>
                        </div>

                        <div class="visualisation-content">


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>
