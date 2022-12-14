<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <title>Loại Hoa</title>
</head>
<body>
    
    <div class="container-fluid">
        <div class="row">
        <?php include_once("../../layout/partials/header.php")?>
        <div class="col-md-3" style="padding: 0;">
            <?php include_once("../../layout/partials/menu.php")?>
        </div>
        <div class="col-md-9 ">
                <h1>Thêm hình ảnh sản phẩm</h1>
                    <?php
                            include_once('../../../connectdb.php');
                            $sql  = "SELECT * FROM hoa";
                            $result = mysqli_query($conn,$sql);
                            
                            $sp = [];
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                $sp[] = array(
                                    'hoa_ma' => $row['hoa_ma'],
                                    'hoa_ten' => $row['hoa_ten'],
                                    );
                            }
                        ?>

                    <form action="" name="frmHinh" id="frmHinh" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="slSp">Sản phẩm</label>
                            <select name="slSp" id="slSp" class="form-control">
                            <?php foreach($sp as $sanpham):?>
                                <option value="<?=$sanpham['hoa_ma']?>"><?= $sanpham['hoa_ten']?></option>
                            <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hsp_tentaptin">Hình ảnh</label>
                            <input type="file" name="hsp_tentaptin" id="hsp_tentaptin" />
                        </div>
                        <div class="preview-img-container">
                        <img src="../../assets/imgs/degault.jpg" id="preview-img" width="200px" />
                        </div>
                        <div class="form-group">
                            <button name="btnLuu" class="btn btn-primary">Lưu</button>
                        </div>
                        <div class="form-group">
                            <a href="index.php" class="btn btn-primary" >Trở lại trang chủ</a>
                        </div>
                    </form>
                </div>
                <?php
                    if(isset($_POST['btnLuu'])){
                        $sp_ma= $_POST['slSp'];
                        if(isset($_FILES['hsp_tentaptin'])){
                            $upload_dir = __DIR__ . "/../../assets/uploads/";
                            // Các hình ảnh sẽ được lưu trong thư mục con `products` để tiện quản lý
                            $subdir = 'products/';

                            if ($_FILES['hsp_tentaptin']['error'] > 0) {
                                echo 'File Upload Bị Lỗi'; die;
                            } else{
                                $tentaptin= $_FILES['hsp_tentaptin']['name'];
                                $ten = date('YmdHis') . '_' . $tentaptin;
                                $sqlInsert="INSERT INTO hinhsanpham(hsp_tentaptin, hoa_ma) VALUES ('$ten', $sp_ma)";
                                $resultInsert=mysqli_query($conn,$sqlInsert);
                                move_uploaded_file($_FILES['hsp_tentaptin']['tmp_name'], $upload_dir.$subdir.$ten);
                            }
                        }
                    }
                    
                ?>
                <script>
                // Hiển thị ảnh preview (xem trước) khi người dùng chọn Ảnh
                const reader = new FileReader();
                const fileInput = document.getElementById("hsp_tentaptin");
                const img = document.getElementById("preview-img");
                reader.onload = e => {
                img.src = e.target.result;
                }
                fileInput.addEventListener('change', e => {
                const f = e.target.files[0];
                reader.readAsDataURL(f);
                })
            </script>
        </div>
    </div>    
    <?php include_once("../../layout/partials/footer.php")?>           
</div>
<?php include_once("../../layout/partials/script.php")?>
</body>
</html>