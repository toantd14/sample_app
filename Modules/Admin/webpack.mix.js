const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/ }));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', 'js/admin/app.js').version()
    .js(__dirname + '/Resources/assets/js/base_ajax.js', 'js/admin/base_ajax.js')
    .js(__dirname + '/Resources/assets/js/create_owner.js', 'js/admin/create_owner.js')
    .js(__dirname + '/Resources/assets/js/find_address.js', 'js/admin/find_address.js')
    .js(__dirname + '/Resources/assets/js/create_owner_bank.js', 'js/admin/create_owner_bank.js')
    .js(__dirname + '/Resources/assets/js/edit_owner.js', 'js/admin/edit_owner.js')
    .js(__dirname + '/Resources/assets/js/edit_owner_bank.js', 'js/admin/edit_owner_bank.js')
    .js(__dirname + '/Resources/assets/js/edit_owner_password.js', 'js/admin/edit_owner_password.js')
    .js(__dirname + '/Resources/assets/js/create_owner_password.js', 'js/admin/create_owner_password.js')
    .js(__dirname + '/Resources/assets/js/parking.js', 'js/admin/parking.js')
    .js(__dirname + '/Resources/assets/js/common.js', 'js/admin/common.js')
    .js(__dirname + '/Resources/assets/js/create_slot_parking.js', 'js/admin/create_slot_parking.js')
    .js(__dirname + '/Resources/assets/js/validate_slot_parking.js', 'js/admin/validate_slot_parking.js')
    .js(__dirname + '/Resources/assets/js/edit_user.js', 'js/admin/edit_user.js')
    .js(__dirname + '/Resources/assets/js/admin-ajax-form-menu.js', 'js/admin/admin-ajax-form-menu.js')
    .sass(__dirname + '/Resources/assets/sass/app.scss', 'css/admin/admin.css')
    .sass(__dirname + '/Resources/assets/sass/login.scss', 'css/admin/login.css')
    .sass(__dirname + '/Resources/assets/sass/reset.scss', 'css/admin/reset.css')
    .sass(__dirname + '/Resources/assets/sass/top.scss', 'css/admin/top.css')
    .sass(__dirname + '/Resources/assets/sass/header.scss', 'css/admin/header.css')
    .sass(__dirname + '/Resources/assets/sass/menu.scss', 'css/admin/menu.css')
    .sass(__dirname + '/Resources/assets/sass/loading.scss', 'css/admin/loading.css')
    .sass(__dirname + '/Resources/assets/sass/validate_register.scss', 'css/admin/validate_register.css')
    .sass(__dirname + '/Resources/assets/sass/register-parking.scss', 'css/admin/register-parking.css')
    .sass(__dirname + '/Resources/assets/sass/slotParking.scss', 'css/admin/slotParking.css')
    .sass(__dirname + '/Resources/assets/sass/bootstrap-datepicker3.standalone.min.scss', 'css/admin/bootstrap-datepicker3.standalone.min.css');

mix.copy(__dirname + '/Resources/assets/js/moment.min.js', '../../public/js/admin/moment.min.js');
mix.copy(__dirname + '/Resources/assets/js/bootstrap-datepicker.min.js', '../../public/js/admin/bootstrap-datepicker.min.js');
mix.copy(__dirname + '/Resources/assets/js/bootstrap-datepicker.ja.min.js', '../../public/js/admin/bootstrap-datepicker.ja.min.js');
mix.copy(__dirname + '/Resources/assets/js/jquery.validate.min.js', '../../public/js/admin/jquery.validate.min.js');
if (mix.inProduction()) {
    mix.version();
}
