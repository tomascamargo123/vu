<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Auth Lang - English
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*
* Author: Daniel Davis
*         @ourmaninjapan
* 
* Author: Josue Ibarra
*         @josuetijuana
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.09.2013
*
* Description:  Spanish language file for Ion Auth example views
*
*/

// Errors
$lang['error_csrf'] = 'Este formulario no pasó nuestras pruebas de seguridad.';

// Login
$lang['login_heading']         = 'Ingresar';
$lang['login_subheading']      = 'Por favor, introduzca su usuario y contraseña.';
$lang['login_identity_label']  = 'Usuario:';
$lang['login_password_label']  = 'Contraseña:';
$lang['login_remember_label']  = 'Recuérdame:';
$lang['login_submit_btn']      = 'Ingresar';
$lang['login_forgot_password'] = '¿Ha olvidado su contraseña?';

// Index
$lang['index_heading']           = 'Usuarios';
$lang['index_subheading']        = 'Debajo está la lista de usuarios.';
$lang['index_fname_th']          = 'Nombre';
$lang['index_lname_th']          = 'Apellidos';
$lang['index_email_th']          = 'Email';
$lang['index_groups_th']         = 'Grupos';
$lang['index_status_th']         = 'Estado';
$lang['index_action_th']         = 'Acción';
$lang['index_active_link']       = 'Activo';
$lang['index_inactive_link']     = 'Inactivo';
$lang['index_create_user_link']  = 'Crear nuevo usuario';
$lang['index_create_group_link'] = 'Crear nuevo grupo';

// Deactivate User
$lang['deactivate_heading']                  = 'Desactivar usuario';
$lang['deactivate_subheading']               = '¿Está seguro que desea desactivar el usuario \'%s\'';
$lang['deactivate_confirm_y_label']          = 'Sí:';
$lang['deactivate_confirm_n_label']          = 'No:';
$lang['deactivate_submit_btn']               = 'Enviar';
$lang['deactivate_validation_confirm_label'] = 'confirmación';
$lang['deactivate_validation_user_id_label'] = 'ID de usuario';

// Create User
$lang['create_user_heading']                           = 'Crear Usuario';
$lang['create_user_subheading']                        = 'Por favor, introduzca la información del usuario.';
$lang['create_user_username_label']                    = 'Usuario';
$lang['create_user_fname_label']                       = 'Nombre';
$lang['create_user_lname_label']                       = 'Apellidos:';
$lang['create_user_company_label']                     = 'Compañía';
$lang['create_user_email_label']                       = 'Email';
$lang['create_user_phone_label']                       = 'Teléfono';
$lang['create_user_password_label']                    = 'Contraseña';
$lang['create_user_password_confirm_label']            = 'Confirmar contraseña';
$lang['create_user_submit_btn']                        = 'Crear Usuario';
$lang['create_user_validation_username_label']         = 'Usuario';
$lang['create_user_validation_fname_label']            = 'Nombre';
$lang['create_user_validation_lname_label']            = 'Apellido';
$lang['create_user_validation_email_label']            = 'Email';
$lang['create_user_validation_phone_label']            = 'Teléfono';
$lang['create_user_validation_company_label']          = 'Nombre de la compañía';
$lang['create_user_validation_password_label']         = 'Contraseña';
$lang['create_user_validation_password_confirm_label'] = 'Confirmación de contraseña';

// Edit User
$lang['edit_user_heading']                           = 'Editar Usuario';
$lang['edit_user_subheading']                        = 'Por favor introduzca la nueva información del usuario.';
$lang['edit_user_username_label']                    = 'Usuario';
$lang['edit_user_fname_label']                       = 'Nombre';
$lang['edit_user_lname_label']                       = 'Apellido';
$lang['edit_user_company_label']                     = 'Compañía';
$lang['edit_user_email_label']                       = 'Email';
$lang['edit_user_phone_label']                       = 'Teléfono';
$lang['edit_user_password_label']                    = 'Contraseña (si quiere cambiarla)';
$lang['edit_user_password_confirm_label']            = 'Confirmar contraseña (si quiere cambiarla)';
$lang['edit_user_groups_heading']                    = 'Miembro de grupos';
$lang['edit_user_submit_btn']                        = 'Modificar Usuario';
$lang['edit_user_validation_fname_label']            = 'Nombre';
$lang['edit_user_validation_lname_label']            = 'Apellido';
$lang['edit_user_validation_email_label']            = 'Email';
$lang['edit_user_validation_phone_label']            = 'Teléfono';
$lang['edit_user_validation_company_label']          = 'Compañía';
$lang['edit_user_validation_groups_label']           = 'Grupos';
$lang['edit_user_validation_password_label']         = 'Contraseña';
$lang['edit_user_validation_password_confirm_label'] = 'Confirmación de contraseña';

// Create Group
$lang['create_group_title']                  = 'Crear Grupo';
$lang['create_group_heading']                = 'Crear Grupo';
$lang['create_group_subheading']             = 'Por favor introduzca la información del grupo.';
$lang['create_group_name_label']             = 'Nombre de Grupo:';
$lang['create_group_desc_label']             = 'Descripción:';
$lang['create_group_submit_btn']             = 'Crear Grupo';
$lang['create_group_validation_name_label']  = 'Nombre de Grupo';
$lang['create_group_validation_desc_label']  = 'Descripcion';

// Edit Group
$lang['edit_group_title']                  = 'Editar Grupo';
$lang['edit_group_saved']                  = 'Grupo Guardado';
$lang['edit_group_heading']                = 'Editar Grupo';
$lang['edit_group_subheading']             = 'Por favor, registre la informacion del grupo.';
$lang['edit_group_name_label']             = 'Nombre de Grupo:';
$lang['edit_group_desc_label']             = 'Descripción:';
$lang['edit_group_submit_btn']             = 'Guardar Grupo';
$lang['edit_group_validation_name_label']  = 'Nombre de Grupo';
$lang['edit_group_validation_desc_label']  = 'Descripción';

// Change Password
$lang['change_password_heading']                               = 'Cambiar Contraseña';
$lang['change_password_old_password_label']                    = 'Antigua Contraseña:';
$lang['change_password_new_password_label']                    = 'Nueva Contraseña (de al menos %s caracteres de longitud):';
$lang['change_password_new_password_confirm_label']            = 'Confirmar Nueva Contraseña:';
$lang['change_password_submit_btn']                            = 'Cambiar';
$lang['change_password_validation_old_password_label']         = 'Antigua Contraseña';
$lang['change_password_validation_new_password_label']         = 'Nueva Contraseña';
$lang['change_password_validation_new_password_confirm_label'] = 'Confirmar Nueva Contraseña';

// Forgot Password
$lang['forgot_password_heading']                 = 'He olvidado mi contraseña';
$lang['forgot_password_subheading']              = 'Por favor, introduzca su usuario para que podamos enviarle un email para restablecer su contraseña.';
$lang['forgot_password_email_label']             = '%s:';
$lang['forgot_password_submit_btn']              = 'Enviar';
$lang['forgot_password_validation_email_label']  = 'Correo Electrónico';
$lang['forgot_password_username_identity_label'] = 'Usuario';
$lang['forgot_password_email_identity_label']    = 'Email';
$lang['forgot_password_email_not_found']         = 'El correo electrónico no existe.';
$lang['forgot_password_identity_not_found']      = 'El usuario no existe.';

// Reset Password
$lang['reset_password_heading']                               = 'Cambiar Contraseña';
$lang['reset_password_new_password_label']                    = 'Nueva contraseña (al menos %s caracteres)';
$lang['reset_password_new_password_confirm_label']            = 'Confirmar nueva contraseña';
$lang['reset_password_submit_btn']                            = 'Aceptar';
$lang['reset_password_validation_new_password_label']         = 'Nueva contraseña';
$lang['reset_password_validation_new_password_confirm_label'] = 'Confirmar nueva contraseña';

// Activation Email
$lang['email_activate_heading']    = 'Activar cuenta por: %s';
$lang['email_activate_subheading'] = 'Por favor ingrese en este link para %s.';
$lang['email_activate_link']       = 'activar su cuenta';

// Forgot Password Email
$lang['email_forgot_password_heading']    = 'Reestablecer contraseña para: %s';
$lang['email_forgot_password_subheading'] = 'Por favor ingrese en este link para %s.';
$lang['email_forgot_password_link']       = 'restablecer su contraseña';

// New Password Email
$lang['email_new_password_heading']    = 'Nueva contraseña para: %s';
$lang['email_new_password_subheading'] = 'Su contraseña ha sido restablecida a: %s';