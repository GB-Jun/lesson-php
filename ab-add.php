<?php require __DIR__ . './parts/connect_db.php';
$pageName = 'ab-add';
$title = '新增通訊資料'
?>
<?php include __DIR__ . './parts/html-head.php' ?>
<?php include __DIR__ . './parts/navbar.php' ?>
<div class="container">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">新增資料</h5>
            <form name="form1" onsubmit="sendData(); return false" novalidate>
                <!-- data-novalidate, data- 開發者自訂的屬性 這邊等於暫時取消他的功能 -->
                <!-- novalidate 是停用html的檢察功能 -->
                <div class="mb-3">
                    <label for="name" class="form-label">* name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                    <div class="form-text"></div>
                    <!-- // 姓名有沒有填 -->
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email">
                    <div class="form-text"></div>
                    <!-- // email 有填的話有沒有符合格式 -->
                </div>
                <div class="mb-3">
                    <label for="mobile" class="form-label">mobile</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" pattern="09\d{8}">
                    <div class="form-text"></div>
                    <!-- // 手機有填的話有沒有符合格式 -->
                </div>
                <div class="mb-3">
                    <label for="birthday" class="form-label">birthday</label>
                    <input type="date" class="form-control" id="birthday" name="birthday">
                    <div class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">address</label>
                    <textarea class="form-control" name="address" id="address" cols="30" rows="3"></textarea>
                    <div class="form-control"></div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

</div>


<?php include __DIR__ . './parts/scripts.php' ?>
<script>
    const email_re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|((a-zA-Z\-0-9]+\.)+[a-zAZ]{2,}))$/;
    const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/;

    // 這邊是拿到欄位的參照而不是值
    const name_f = document.form1.name;
    const email_f = document.form1.email;
    const mobile_f = document.form1.mobile;


    async function sendData() {
        // TODO: 1.檢查欄位, 前端的檢查 2.取表單內容
        let isPass = true; // 預設是通過檢查

        if (name_f.value.length < 2) {
            alert('姓名至少兩個字');
            ifPass = false;
        }
        // 有填內容時 email_f.value的boolean就會為true, 才會檢查格式, test是檢查()裡面的值是否有符合前面的regExp規則, 有為true, 沒有為false
        if (email_f.value && !email_re.test(email_f.value)) {
            alert('email 格式錯誤');
            isPass = false;
        }
        if (mobile_f.value && !mobile_re.test(email_f.value)) {
            alert('手機格式錯誤');
            isPass = false;
        }


        if (!isPass) {
            return; // 沒有通過時, 就直接結束函式
        }

        const fd = new FormData(document.form1);
        const r = await fetch('ab-add-api.php', {
            method: 'POST',
            body: fd,
        });
        const result = await r.json();
        console.log(result);
    }
</script>
<?php include __DIR__ . './parts/html-foot.php' ?>