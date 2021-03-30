<div class="mb-3 col-lg-2 col-sm-12">
    <label for="inputStart" class="form-label">Provincia</label>
    <select class="form-control provincia-select" id="select_partenza" required="" name="provincia">
        <?php
                            include_once('config.php');
                            # usiamo i prepared statement (sempre mysqli) per evitare injection
                            $stmt = $conn->prepare("SELECT nome_province, sigla_province FROM province");
                            $stmt->execute();
                            
                            if ($res = $stmt->get_result()) {
                                while ($row = $res->fetch_assoc()) {
                                    $data_array[] = $row;
                                }
                            }
                            
                            foreach ($data_array as $data) {
                                echo "<option value='{$data['sigla_province']}'>{$data['nome_province']}</option>";
                            }

                            echo ' </select>                  
                            </div>
                            <div class="mb-3 col-lg-4 col-sm-12">
                                <label for="inputStart" class="form-label">Città di partenza</label>
                                <select class="form-control" id="citta_partenza" required="" name="citta_partenza"></select>
                            </div>

                            <div class="mb-3 col-lg-2 col-sm-12">
                            <label for="inputStart" class="form-label">Provincia</label>
                            <select class="form-control" id="select_arrivo" required="" name="provincia_arrivo">
                            ';

                            foreach ($data_array as $data) {
                                echo "<option value='{$data['sigla_province']}'>{$data['nome_province']}</option>";
                            }
                            echo ' </select>                  
                            </div>';
                            ?>

        <div class="mb-3 col-lg-4">
            <label for="citta_arrivo" class="form-label">Città di arrivo</label>
            <select class="form-control provincia-select" id="citta_arrivo" required="" name="citta_arrivo"></select>
        </div>
</div>