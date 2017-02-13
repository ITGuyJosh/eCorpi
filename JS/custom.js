
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

        // $('.context-menu-one').on('click', function(e){
        //     var selection = $('option:selected',this).text();
        //     if selection == "assign-tags" {
        //         console.log('clicked');
        //     }
        //
        // })
    });
