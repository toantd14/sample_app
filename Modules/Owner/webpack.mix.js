const dotenvExpand = require('dotenv-expand');
dotenvExpand(require('dotenv').config({path: '../../.env'/*, debug: true*/}));

const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', 'js/owner.js').version()
    .js(__dirname + '/Resources/assets/js/base_ajax.js', 'js/base_ajax.js')
    .js(__dirname + '/Resources/assets/js/register_member.js', 'js/register_member.js')
    .js(__dirname + '/Resources/assets/js/find_address.js', 'js/find_address.js')
    .js(__dirname + '/Resources/assets/js/parking.js', 'js/parking.js')
    .js(__dirname + '/Resources/assets/js/use_situation.js', 'js/use_situation.js')
    .js(__dirname + '/Resources/assets/js/show_menu_parking.js', 'js/show_menu_parking.js')
    .js(__dirname + '/Resources/assets/js/create_slot_parking.js', 'js/create_slot_parking.js')
    .js(__dirname + '/Resources/assets/js/sucess_modal.js', 'js/sucess_modal.js')
    .js(__dirname + '/Resources/assets/js/common.js', 'js/common.js')
    .js(__dirname + '/Resources/assets/js/auth.js', 'js/auth.js')
    .js(__dirname + '/Resources/assets/js/notification.js', 'js/notification.js')
    .js(__dirname + '/Resources/assets/js/validate_owner_edit.js', 'js/validate_owner_edit.js')
    .js(__dirname + '/Resources/assets/js/validate_owner_bank.js', 'js/validate_owner_bank.js')
    .js(__dirname + '/Resources/assets/js/validate_owner_reset_password.js', 'js/validate_owner_reset_password.js')
    .js(__dirname + '/Resources/assets/js/validate_slot_parking.js', 'js/validate_slot_parking.js')
    .js(__dirname + '/Resources/assets/js/edit_user.js', 'js/edit_user.js')
    .js(__dirname + '/Resources/assets/js/ajax_form_menu.js', 'js/ajax_form_menu.js')
    .sass(__dirname + '/Resources/assets/sass/app.scss', 'css/owner.css')
    .sass(__dirname + '/Resources/assets/sass/login.scss', 'css/login.css')
    .sass(__dirname + '/Resources/assets/sass/reset.scss', 'css/reset.css')
    .sass(__dirname + '/Resources/assets/sass/parking.scss', 'css/parking.css')
    .sass(__dirname + '/Resources/assets/sass/register-parking.scss', 'css/register-parking.css')
    .sass(__dirname + '/Resources/assets/sass/confirmPassword.scss', 'css/confirmPassword.css')
    .sass(__dirname + '/Resources/assets/sass/slotParking.scss', 'css/slotParking.css')
    .sass(__dirname + '/Resources/assets/sass/top.scss', 'css/top.css')
    .sass(__dirname + '/Resources/assets/sass/menu.scss', 'css/menu.css')
    .sass(__dirname + '/Resources/assets/sass/menus-manager.scss', 'css/menus-manager.css')
    .sass(__dirname + '/Resources/assets/sass/header.scss', 'css/header.css')
    .sass(__dirname + '/Resources/assets/sass/list-notification.scss', 'css/list-notification.css')
    .sass(__dirname + '/Resources/assets/sass/update_menu_parking.scss', 'css/update_menu_parking.css')
    .sass(__dirname + '/Resources/assets/sass/notification.scss', 'css')
    .sass(__dirname + '/Resources/assets/sass/loading.scss', 'css')
    .sass(__dirname + '/Resources/assets/sass/validate_register.scss', 'css')
    .sass(__dirname + '/Resources/assets/sass/bootstrap-datepicker3.standalone.min.scss', 'css')
    .sass(__dirname + '/Resources/assets/sass/edit_user.scss', 'css')
    .sass(__dirname + '/Resources/assets/sass/parkingtimepicker.scss', 'css')
    .sass(__dirname + '/Resources/assets/sass/register-owner.scss', 'css')
    .sass(__dirname + '/Resources/assets/sass/edit-owner.scss', 'css');

mix.copy(__dirname + '/Resources/assets/js/moment.min.js', '../../public/js/moment.min.js');
mix.copy(__dirname + '/Resources/assets/js/jquery.validate.min.js', '../../public/js/jquery.validate.min.js');
mix.copy(__dirname + '/Resources/assets/js/upcTokenPaymentMini.js', '../../public/js/upcTokenPaymentMini.js');
mix.copy(__dirname + '/Resources/assets/js/bootstrap-datepicker.min.js', '../../public/js/bootstrap-datepicker.min.js');
mix.copy(__dirname + '/Resources/assets/js/bootstrap-datepicker.ja.min.js', '../../public/js/bootstrap-datepicker.ja.min.js');

if (mix.inProduction()) {
    mix.version();
}
