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
                    <li data-toggle="modal" data-target="#load-modal"><a href="#">Load</a></li>
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
    <div class="modals"></div>


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
