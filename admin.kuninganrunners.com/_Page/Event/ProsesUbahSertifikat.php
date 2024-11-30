<?php
    // Include file koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d H:i:s');

    // Response default
    $response = [
        'success' => false,
        'message' => 'Terjadi kesalahan.'
    ];

    if(empty($SessionIdAkses)){
        $response = [
            'success' => false,
            'message' => 'Sesi Akses Sudah Berakhir, Silahkan Login Ulang!'
        ];
    } else {
        try {
            // Tangkap data POST
            $id_event = $_POST['id_event'] ?? null;
            $canvas_length_value = $_POST['canvas_length_value'] ?? null;
            $canvas_length_unit = $_POST['canvas_length_unit'] ?? null;
            $canvas_wide_value = $_POST['canvas_wide_value'] ?? null;
            $canvas_wide_unit = $_POST['canvas_wide_unit'] ?? null;
            $canvas_margin_top_value = $_POST['canvas_margin_top_value'] ?? null;
            $canvas_margin_top_unit = $_POST['canvas_margin_top_unit'] ?? null;
            $canvas_margin_bottom_value = $_POST['canvas_margin_bottom_value'] ?? null;
            $canvas_margin_bottom_unit = $_POST['canvas_margin_bottom_unit'] ?? null;
            $canvas_margin_left_value = $_POST['canvas_margin_left_value'] ?? null;
            $canvas_margin_left_unit = $_POST['canvas_margin_left_unit'] ?? null;
            $canvas_margin_right_value = $_POST['canvas_margin_right_value'] ?? null;
            $canvas_margin_right_unit = $_POST['canvas_margin_right_unit'] ?? null;
            $participant_name_font_family = $_POST['participant_name_font_family'] ?? null;
            $participant_name_font_color = $_POST['participant_name_font_color'] ?? null;
            $participant_name_font_size_value = $_POST['participant_name_font_size_value'] ?? null;
            $participant_name_font_size_unit = $_POST['participant_name_font_size_unit'] ?? null;
            $participant_name_text_align = $_POST['participant_name_text_align'] ?? null;
            $participant_name_font_style = $_POST['participant_name_font_style'] ?? null;
            $participant_name_font_weight = $_POST['participant_name_font_weight'] ?? null;
            $participant_name_font_decoration = $_POST['participant_name_font_decoration'] ?? null;
            $margin_top_content_value = $_POST['margin_top_content_value'] ?? null;
            $margin_top_content_unit = $_POST['margin_top_content_unit'] ?? null;
            $qr_code_correction = $_POST['qr_code_correction'] ?? null;
            $qr_code_pixel_block = $_POST['qr_code_pixel_block'] ?? null;
            $publish = $_POST['publish'] ?? 'Tidak';
            $background_image = "";

            // Validasi data wajib
            if (!$id_event) {
                throw new Exception('ID Event wajib diisi.');
            }

            // Proses upload file jika ada
            if (isset($_FILES['background_image']) && $_FILES['background_image']['error'] == UPLOAD_ERR_OK) {
                $file = $_FILES['background_image'];
                $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
                $max_size = 5 * 1024 * 1024; // 5 MB

                // Validasi ukuran file
                if ($file['size'] > $max_size) {
                    throw new Exception('Ukuran file maksimal 5 MB.');
                }

                // Validasi format file
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                if (!in_array($ext, $allowed_types)) {
                    throw new Exception('Format file tidak didukung. Gunakan jpg, jpeg, png, atau gif.');
                }

                // Buat nama file baru
                $new_file_name = bin2hex(random_bytes(18)) . '.' . $ext;
                $upload_path = "../../assets/img/Sertifikat/" . $new_file_name;

                // Pindahkan file ke folder tujuan
                if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
                    throw new Exception('Gagal mengunggah file.');
                }

                $background_image = $new_file_name;
            } else {
                // Mengambil data background image jika tidak diupload
                $sertifikat = GetDetailData($Conn, 'event', 'id_event', $id_event, 'sertifikat');
                if (!empty($sertifikat)) {
                    $sertifikat_array = json_decode($sertifikat, true);
                    $background_image = $sertifikat_array['background_image'];
                }
            }

            // Menyusun data JSON sesuai dengan struktur yang diinginkan
            $sertifikat_data = json_encode([
                'publish' => $publish,
                'canvas' => [
                    'length' => [
                        'value' => $canvas_length_value,
                        'unit' => $canvas_length_unit
                    ],
                    'wide' => [
                        'value' => $canvas_wide_value,
                        'unit' => $canvas_wide_unit
                    ],
                    'margin-top' => [
                        'value' => $canvas_margin_top_value,
                        'unit' => $canvas_margin_top_unit
                    ],
                    'margin-right' => [
                        'value' => $canvas_margin_right_value,
                        'unit' => $canvas_margin_right_unit
                    ],
                    'margin-bottom' => [
                        'value' => $canvas_margin_bottom_value,
                        'unit' => $canvas_margin_bottom_unit
                    ],
                    'margin-left' => [
                        'value' => $canvas_margin_left_value,
                        'unit' => $canvas_margin_left_unit
                    ]
                ],
                'participant_name' => [
                    'font-family' => $participant_name_font_family,
                    'font-color' => $participant_name_font_color,
                    'font-size' => [
                        'value' => $participant_name_font_size_value,
                        'unit' => $participant_name_font_size_unit
                    ],
                    'font-style' => $participant_name_font_style,
                    'font-weight' => $participant_name_font_weight,
                    'font-decoration' => $participant_name_font_decoration,
                    'text-align' => $participant_name_text_align
                ],
                'margin_top_content' => [
                    'unit' => $margin_top_content_unit,
                    'value' => $margin_top_content_value
                ],
                'qr_code' => [
                    'correction' => $qr_code_correction,
                    'pixel_block' => $qr_code_pixel_block
                ],
                'background_image' => $background_image
            ], JSON_PRETTY_PRINT);

            // Update ke database
            $stmt = $Conn->prepare("UPDATE event SET sertifikat = ? WHERE id_event = ?");
            $stmt->bind_param('ss', $sertifikat_data, $id_event);

            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Pengaturan sertifikat berhasil disimpan.';
            } else {
                throw new Exception('Gagal menyimpan pengaturan sertifikat.');
            }
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }
    }

    // Kirimkan response
    header('Content-Type: application/json');
    echo json_encode($response);
?>
