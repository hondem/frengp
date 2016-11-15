tinymce.init({
    selector:'textarea',
    plugins: ['image link jbimages responsivefilemanager'],
    toolbar: ['undo redo | styleselect | bold italic underline | responsivefilemanager'],
    image_advtab: true,
    relative_urls: false,
    external_filemanager_path: {$basePath} + '/filemanager/',
    filemanager_title:'Filemanager',
    external_plugins: {'filemanager' : {$basePath} + '/js/tinymce/plugins/responsivefilemanager/plugin.min.js'}
});