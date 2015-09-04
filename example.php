<?php
/**
 * Armature
 *
 * @link          https://github.com/Armature
 * @author        Oleg Budrin <ru.mofsy@yandex.ru>
 * @author_link   https://mofsy.ru
 * @copyright     Copyright (c) 2015, Oleg Budrin (Mofsy)
 */

$time_start = microtime(true);
include_once(__DIR__ . DIRECTORY_SEPARATOR . 'client.class.php' );

/**
 * Создаем экземпляр класса
 */
$armature = new Armature\Client\Main();

/**
 * Указываем директорию с правами на запись.
 * В эту директорию будет скачиваться файл локального ключа с сервера.
 */
$armature->local_key_path = './';

/**
 * Указываем название файла в котором будет храниться локальный ключ.
 */
$armature->local_key_name = 'license.lic';

/**
 * Указываем полный путь до сервера лицензий.
 */
$armature->server = 'http://localhost/api.php';

/**
 * Указываем ключ активации, например из конфигурации.
 */
$armature->activation_key = 'WEFSZ-ERGER-GRGER-NGNFG-SDFSF';

/**
 * Указываем дату релиза скрипта
 */
$armature->release_date = '2014-10-02';

/**
 * Устанавливаем локализацию статусов и ошибок
 */
$armature->status_messages = array(
    'status_1'                       => '<span style="color:green;">Активна</span>',
    'status_2'                       => '<span style="color:darkblue;">Внимание</span>: срок действия лицензии закончился.',
    'status_3'                       => '<span style="color:orange;">Внимание</span>: лицензия переиздана. Ожидает повторной активации.',
    'status_4'                       => '<span style="color:red;">Ошибка</span>: лицензия была приостановлена.',
    'localhost'                      => '<span style="color:orange;">Активна на localhost</span>: используется локальный компьютер, на реальном сервере произойдет активация, если вы правильно ввели лицензионный ключ активации в настройках.',
    'pending'                        => '<span style="color:red;">Ошибка</span>: лицензия ожидает рассмотрения.',
    'download_access_expired'        => '<span style="color:red;">Ошибка</span>: ключ активации не подходит для установленной версии. Пожалуйста поставьте более старую версию продукта.',
    'missing_activation_key'         => '<span style="color:red;">Ошибка</span>: ключ активации не указан.',
    'could_not_obtain_local_key'     => '<span style="color:red;">Ошибка</span>: невозможно получить новый локальный ключ.',
    'maximum_delay_period_expired'   => '<span style="color:red;">Ошибка</span>: льготный период локального ключа истек.',
    'local_key_tampering'            => '<span style="color:red;">Ошибка</span>: локальный лицензионный ключ поврежден или не действителен.',
    'local_key_invalid_for_location' => '<span style="color:red;">Ошибка</span>: локальный ключ не подходит к данному окружению.',
    'missing_license_file'           => '<span style="color:red;">Ошибка</span>: создайте следующий пустой файл и папки если их нету:<br />',
    'license_file_not_writable'      => '<span style="color:red;">Ошибка</span>: сделайте для записи следующие пути:<br />',
    'invalid_local_key_storage'      => '<span style="color:red;">Ошибка</span>: не возможно удалить старый локальный ключ.',
    'could_not_save_local_key'       => '<span style="color:red;">Ошибка</span>: не возможно записать новый локальный ключ.',
    'activation_key_string_mismatch' => '<span style="color:red;">Ошибка</span>: локальный ключ не действителен для указанного ключа активации.'
);

/**
 * Запускаем валидацию
 */
$armature->validate();

/**
 * Если истина, то лицензия в боевом состоянии
 */
if ($armature->status) {
    $license = true;
}

/**
 * Можно вывести текстовый статус лицензии
 *
 * NOTE: например в панели скрипта или в лог, что бы знать в каком состоянии находится лицензия.
 */
echo 'Статус: ' . $armature->errors;

/**
 * Так же можно вывести имя (логин), на которое выдана лицензия
 */
echo '<br />Имя, на которое выдан ключ активации: ' . $armature->user_name;

/**
 * Так же можно вывести дату окончания лицензии
 */
if(is_numeric($armature->activation_key_expires) && $armature->activation_key_expires > 0) {
    echo '<br />Ключ действует до ' . date('j F Y, H:i', $armature->activation_key_expires);
} else {
    echo '<br />Ключ действует вечно';
}

$time_end = microtime(true);
$time = $time_end - $time_start;

echo "<br /> Выполнялось $time секунд\n";