<?php require __DIR__ . './parts/connect_db.php';
$pageName = 'ab-edit';
$title = '編輯通訊資料';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location: ab-list.php');
    exit;
}

$row = $pdo->query("SELECT * FROM address_book WHERE sid=$sid")->fetch();
if (empty($row)) {
    header('Location: ab-list.php');
    exit;
}






?>
<?php include __DIR__ . './parts/html-head.php' ?>
<?php include __DIR__ . './parts/navbar.php' ?>
<style>
    .form-control.red {
        border: 1px solid red;
    }

    .red {
        color: red;
    }
</style>
<div class="container">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">編輯資料</h5>
            <form name="form1" onsubmit="sendData(); return false" novalidate>
                <div class="mb-3">
                    <label for="name" class="form-label">* name</label>
                    <input type="text" class="form-control" id="name" name="name" required value="<?= htmlentities($row['name'])
                    // 為了避免XSS 另外可以用strip_tags
                    ?>">
                    <div class="form-text red"></div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $row['email'] ?>">
                    <div class="form-text red"></div>
                </div>
                <div class="mb-3">
                    <label for="mobile" class="form-label">mobile</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" pattern="09\d{8}" value="<?= $row['mobile'] ?>">
                    <div class="form-text red"></div>
                </div>
                <div class="mb-3">
                    <label for="birthday" class="form-label">birthday</label>
                    <input type="date" class="form-control" id="birthday" name="birthday" value="<?= ($row['birthday']) ?>">
                    <div class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">address</label>
                    <textarea class="form-control" name="address" id="address" cols="30" rows="3"><?= htmlentities($row['name']) ?>"</textarea>
                    <div class="form-control"></div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <div id="info_bar" class="alert alert-success" role="alert" style="display:none;">
                    資料修改成功
                </div>
            </form>
        </div>
    </div>

</div>


<?php include __DIR__ . './parts/scripts.php' ?>
<script>
    const row = <?= json_encode($row, JSON_UNESCAPED_UNICODE); ?>;



    const email_re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zAZ]{2,}))$/;
    const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/;

    const info_bar = document.querySelector('#info_bar');
    const name_f = document.form1.name;
    const email_f = document.form1.email;
    const mobile_f = document.form1.mobile;

    const fields = [name_f, email_f, mobile_f];
    const fieldTexts = [];
    for (let f of fields) {
        fieldTexts.push(f.nextElementSibling);
    }


    async function sendData() {
        for (let i in fields) {
            fields[i].classList.remove('red');
            fieldTexts[i].innerText = '';
        }
        info_bar.style.display = 'none';


        let isPass = true;

        if (name_f.value.length < 2) {
            fields[0].classList.add('red');
            fieldTexts[0].innerText = '姓名至少兩個字';
            isPass = false;
        }
        if (email_f.value && !email_re.test(email_f.value)) {
            fields[1].classList.add('red');
            fieldTexts[1].innerText = 'email 格式錯誤';
            isPass = false;
        }
        if (mobile_f.value && !mobile_re.test(mobile_f.value)) {
            fields[2].classList.add('red');
            fieldTexts[2].innerText = '手機格式錯誤';
            isPass = false;
        }


        if (!isPass) {
            return;
        }

        const fd = new FormData(document.form1);
        const r = await fetch('ab-add-api.php', {
            method: 'POST',
            body: fd,
        });
        const result = await r.json();
        console.log(result);
        info_bar.style.display = 'block'; // 顯示訊息列
        if (result.success) {
            info_bar.classList.remove('alert-danger');
            info_bar.classList.add('alert-success');
            info_bar.innerText = '新增成功0'


            // setTimeout(() => {
            //     location.href = 'ab-list.php'; // 跳轉列表頁
            // }, 2000)
        } else {
            info_bar.classList.remove('alert-success');
            info_bar.classList.add('alert-danger');
            info_bar.innerText = result.error || '資料無法新增1';
        }
    }
</script>
<?php include __DIR__ . './parts/html-foot.php' ?>