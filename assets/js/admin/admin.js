jQuery(document).ready(function($) {
    // Cargador de medios
    function illuminaMediaUploader() {
        var fileFrame;
        
        $('.illumina-logo-field .logo-preview-container').on('click', function(e) {
            e.preventDefault();
            
            var container = $(this);
            var inputField = container.siblings('input[type="hidden"]');
            
            if (fileFrame) {
                fileFrame.open();
                return;
            }
            
            fileFrame = wp.media.frames.fileFrame = wp.media({
                title: 'Seleccionar o subir imagen',
                button: {
                    text: 'Usar esta imagen'
                },
                multiple: false
            });
            
            fileFrame.on('select', function() {
                var attachment = fileFrame.state().get('selection').first().toJSON();
                inputField.val(attachment.url);
                container.html('<img src="' + attachment.url + '" class="logo-preview" alt="Logo preview">');
            });
            
            fileFrame.open();
        });
    }
    
    // Inicializa el cargador de medios
    illuminaMediaUploader();
});