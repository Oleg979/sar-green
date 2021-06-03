<?php

// Роутер для загрузки файлов на сервер
function route($method, $urlData, $formData) {
    // Загружаем один файл
    // POST /upload
    if ($method === 'POST' && count($urlData) === 0) {
        $filename = upload();
        header('Content-Type: application/json');
        echo json_encode([
            "success" => true,
            "filename" => $filename
        ]);
        return;
    }

    // Получаем файл
    // GET /upload/{name}
    if ($method === 'GET' && count($urlData) === 1) {
        $file_out = "uploads/".$urlData[0];
        if (file_exists($file_out)) {
            $image_info = getimagesize($file_out);
            header('Content-Type: ' . $image_info['mime']);
            header('Content-Length: ' . filesize($file_out));
            readfile($file_out);
        } else {
            header('Content-Type: image/jpeg');
            readfile("uploads/404.jpg");
        }
        return;
    }

    // Получаем отчёт
    // GET upload/report/{name}
    if ($method === 'GET' && count($urlData) === 2 && $urlData[0] == "report") {
        $file_out = "report-generator/Report_".$urlData[0].".docx";
            $image_info = getimagesize($file_out);
            header('Content-Type: ' . $image_info['mime']);
            header('Content-Length: ' . filesize($file_out));
            readfile($file_out);
        return;
    }


    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(array(
        'error' => 'У нас нет такого запроса. Проверьте УРЛ.'
    ));
}
