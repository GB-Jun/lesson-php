<?php require __DIR__ . './parts/connect_db.php';
$pageName = 'ab-add';
$title = '新增通訊資料'
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
            <h5 class="card-title">新增資料</h5>
            <form name="form1" onsubmit="sendData(); return false" novalidate>
                <!-- data-novalidate, data- 開發者自訂的屬性 這邊等於暫時取消他的功能 -->
                <!-- novalidate 是停用html的檢察功能 -->
                <div class="mb-3">
                    <label for="name" class="form-label">* name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                    <div class="form-text red"></div>
                    <!-- // 姓名有沒有填 -->
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email">
                    <div class="form-text red"></div>
                    <!-- // email 有填的話有沒有符合格式 -->
                </div>
                <div class="mb-3">
                    <label for="mobile" class="form-label">mobile</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" pattern="09\d{8}">
                    <div class="form-text red"></div>
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
                <div id="info_bar" class="alert alert-success" role="alert" style="display:none;">
                    資料新增成功
                </div>
            </form>
        </div>
    </div>

</div>


<?php include __DIR__ . './parts/scripts.php' ?>
<script>
    const email_re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zAZ]{2,}))$/;
    const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/;

    // 這邊是拿到欄位的參照而不是值
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
        // 當格式正確後讓欄位的外觀回復原來的狀態
        for (let i in fields) {
            fields[i].classList.remove('red');
            fieldTexts[i].innerText = '';
        }
        info_bar.style.display = 'none'; // 都沒有時先隱藏訊息列


        // TODO: 1.檢查欄位, 前端的檢查 2.取表單內容
        let isPass = true; // 預設是通過檢查

        if (name_f.value.length < 2) {
            // 盡量不要用alert, 他會停止讀取
            // alert('姓名至少兩個字');
            // 先寫css, 然後在html裡面測試後, 刪掉加上的class再回來這邊寫


            // 可以查classlist, 以前是用className, nextElememtSibling也是新使用(牽扯到了dom的遊走)
            // name_f.classList.add('red');
            // name_f.nextElementSibling.classlist.add('red');

            // 先用closest向外找()內的標籤, 用parentNode是向上一層 , 再用querySelector向內找()內的標籤
            // name_f.closest('.mb-3').querySelector('.form-text').classList.add('red');

            // 用一個全部測試完之後 再改成迴圈來寫, 並加到全部需要的
            fields[0].classList.add('red');
            // fieldTexts[0].classList.add('red'); 直接加到HTML裡面, 沒有文字也不會顯示, 所以不用刪掉或新增這個div的red class
            fieldTexts[0].innerText = '姓名至少兩個字';
            isPass = false;
        }
        // 有填內容時 email_f.value的boolean就會為true, 才會檢查格式, test是檢查()裡面的值是否有符合前面的regExp規則, 有為true, 沒有為false
        if (email_f.value && !email_re.test(email_f.value)) {
            // alert('email 格式錯誤');
            fields[1].classList.add('red');
            fieldTexts[1].innerText = 'email 格式錯誤';
            isPass = false;
        }
        if (mobile_f.value && !mobile_re.test(mobile_f.value)) {
            // alert('手機格式錯誤');
            fields[2].classList.add('red');
            fieldTexts[2].innerText = '手機格式錯誤';
            isPass = false;
        }


        if (!isPass) {
            return; // 結束函式
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