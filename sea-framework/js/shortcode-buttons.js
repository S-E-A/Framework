jQuery(document).ready(function($) {
    
    function onPostRender() {
        for( var index = 0; index < this.items()[0].items().length; index++ ) {
            
            var id = this.items()[0].items()[index].items()[1]._id;
            
            if ( this.items()[0].items()[index].items()[1].classes().indexOf( 'mce-bootstrap-size' ) >= 0 ){
             
                bootstrapSize( id );
                
            }
            
        }
    }
    
    function bootstrapSize( id ) {
        
        $( '#' + id ).attr( 'min', 1 );
        $( '#' + id ).attr( 'max', 12 );
        
    }
    
    var good = '';
    $( document ).on( 'keyup', '.mce-numbers-only', function( event ) {
        
        var input = $( this );
        
        if ( event.which !== 8 ) { // If not backspace
            var matchedPosition = input.val().search( /[a-z@#!$%,-^&*()_+|~=`{}\[\]:";'<>?.\/\\]/i );
            if( matchedPosition === -1 ) {
                input.val( good );
            }
            else{
                good = input.val();
            }
            
        }
            
        if ( input.val() === '0' ) {
            input.val( '' );
        }
        
    });
    
    $( document ).on( 'keyup', '.mce-letters-only', function( event ) {
        var input = $( this );
        var matchedPosition;
        
        if ( event.which !== 8 ) { // If not backspace
            
            if ( input.hasClass( 'mce-no-spaces' ) ) {
                matchedPosition = input.val().search( /^[a-z]*$/i );
            }
            else{
                matchedPosition = input.val().search( /^[a-z ]*$/i );
            }
            
            if( matchedPosition === -1 ) {
                input.val( good );
            }
            else{
                good = input.val();
            }
            
        }
        
    });

    tinymce.PluginManager.add('bootstrap_shortcode_button', function( editor, url ) {
        editor.addButton( 'bootstrap_shortcode_button', {
            text: 'Bootstrap Shortcodes',
            icon: false,
            type: 'menubutton',
            menu: [
                {
                    text: 'Row',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Create Row Element',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'classes',
                                    classes: 'letters-only',
                                    label: 'Additional Classes (Optional, Separated By Spaces)'
                                },
                                {
                                    type: 'textbox',
                                    name: 'id',
                                    classes: 'letters-only no-spaces',
                                    label: 'ID (Optional)'
                                }
                            ],
                            onPostRender: onPostRender,
                            onsubmit: function( e ) {
                                editor.insertContent( '[row' + ( e.data.id !== '' ? ' id="' + e.data.id + '"' : '' ) + ( e.data.classes !== '' ? ' classes="' + e.data.classes + '"' : '' ) + ']Content Goes Here[/row]' );
                            }
                        });
                    }
                },
                {
                    text: 'Column',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Create Column Element',
                            body: [
                                {
                                    type: 'textbox',
                                    subtype: 'number',
                                    classes: 'bootstrap-size numbers-only',
                                    name: 'lg',
                                    label: 'Large Screens'
                                },
                                {
                                    type: 'textbox',
                                    subtype: 'number',
                                    classes: 'bootstrap-size numbers-only',
                                    name: 'lgOffset',
                                    label: 'Offset on Large Screens (Optional)'
                                },
                                {
                                    type: 'textbox',
                                    subtype: 'number',
                                    classes: 'bootstrap-size numbers-only',
                                    name: 'md',
                                    label: 'Medium Screens (iPads)'
                                },
                                {
                                    type: 'textbox',
                                    subtype: 'number',
                                    classes: 'bootstrap-size numbers-only',
                                    name: 'mdOffset',
                                    label: 'Offset on Medium Screens (Optional)'
                                },
                                {
                                    type: 'textbox',
                                    subtype: 'number',
                                    classes: 'bootstrap-size numbers-only',
                                    name: 'sm',
                                    label: 'Small Screens (Tablets and Landscape Smart Phones)'
                                },
                                {
                                    type: 'textbox',
                                    subtype: 'number',
                                    classes: 'bootstrap-size numbers-only',
                                    name: 'smOffset',
                                    label: 'Offset on Small Screens (Optional)'
                                },
                                {
                                    type: 'textbox',
                                    subtype: 'number',
                                    classes: 'bootstrap-size numbers-only',
                                    name: 'xs',
                                    label: 'Extra Small Screens (Portrait Smart Phones)'
                                },
                                {
                                    type: 'textbox',
                                    subtype: 'number',
                                    classes: 'bootstrap-size numbers-only',
                                    name: 'xsOffset',
                                    label: 'Offset on Extra Small Screens (Optional)'
                                },
                                {
                                    type: 'textbox',
                                    name: 'classes',
                                    classes: 'letters-only',
                                    label: 'Additional Classes (Optional, Separated By Spaces)'
                                },
                                {
                                    type: 'textbox',
                                    name: 'id',
                                    classes: 'letters-only no-spaces',
                                    label: 'ID (Optional)'
                                }
                            ],
                            onPostRender: onPostRender,
                            onsubmit: function( e ) {
                                editor.insertContent( '[col' + ( e.data.id !== '' ? ' id="' + e.data.id + '"' : '' ) + ( e.data.lg !== '' ? ' lg="' + e.data.lg + '"' : '' ) + ( e.data.lgOffset !== '' ? ' lg_offset="' + e.data.lgOffset + '"' : '' ) + ( e.data.md !== '' ? ' md="' + e.data.md + '"' : '' ) + ( e.data.mdOffset !== '' ? ' md_offset="' + e.data.mdOffset + '"' : '' ) + ( e.data.sm !== '' ? ' sm="' + e.data.sm + '"' : '' ) + ( e.data.smOffset !== '' ? ' sm_offset="' + e.data.smOffset + '"' : '' ) + ( e.data.xs !== '' ? ' xs="' + e.data.xs + '"' : '' ) + ( e.data.xsOffset !== '' ? ' xs_offset="' + e.data.xsOffset + '"' : '' ) + ( e.data.classes !== '' ? ' classes="' + e.data.classes + '"' : '' ) + ']Content Goes Here[/col]' );
                            }
                        });
                    }
                }
           ]
        });
    });
    
});