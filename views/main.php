<?php

require_once '../config/bootstrap.php';

$trans = require_once "../lang/" . $_SESSION['lang'] . ".php";

if (!$auth->check()) {
    header("Location: /views/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['sendSMS'])) {
        $groupId = $_POST['groupId'];
        $message = $_POST['message'];

        if ($smsService->SaveSMS($groupId, $message)) {
        }
    }

    if (isset($_POST['group_id'])) {
        $_SESSION['group_id'] = $_POST['group_id'];
        $_SESSION['group_title'] = $_POST['group_title'];
    }

    if (isset($_POST['groupIdClearHistory'])) {
        if ($smsService->clearHistory($_POST['groupIdClearHistory'])) {
            echo '<script>alert("ok")</script>';
        } else {
 echo '<script>alert("no")</script>';
        }     
  
    }
}

$selectedGroupId = $_SESSION['group_id'] ?? '1';

?>



<?php include_once 'components/header.php'; ?>

<style>
    /* Asosiy tanasi */
    body {
        background-color: #F1F3F4;
        /* Google Gray fon */
        color: #202124;
        /* Qora matn */
        font-family: 'Roboto', sans-serif;
        font-size: 16px;
        margin: 0;
        padding: 0;
    }

    .card {
        background: #fff;
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        color: #202124;
        margin-bottom: 20px;
    }

    .card-header {
        background: #4285f4;
        /* Google ko'k rang */
        color: white;
        font-size: 1.5rem;
        font-weight: 500;
        padding: 20px;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    /* Asosiy Konteyner */
    .main-content {
        display: flex;
        height: 80vh;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    }

    /* Yon Panel */
    .sidebar {
        width: 280px;
        background: #FFFFFF;
        /* Oq fon */
        padding: 30px;
        border-right: 2px solid #E0E0E0;
        /* Ajratish chizig‘i */
    }

    .sidebar h5 {
        margin-bottom: 30px;
        font-weight: 700;
        font-size: 22px;
        color: #4285F4;
        /* Google Blue */
        text-transform: uppercase;
    }

    /* Guruhlar Ro'yxati */
    .list-group-item {
        background: #FFFFFF;
        /* Oq fon */
        color: #202124;
        padding: 18px 24px;
        border-radius: 8px;
        margin-bottom: 18px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 1px solid #E0E0E0;
    }

    .list-group-item:hover {
        background: #F4B400;
        /* Google Yellow */
        color: #FFFFFF;
        transform: translateX(5px);
    }

    .selected {
        background: #0F9D58;
        /* Google Green */
        color: #FFFFFF !important;
    }

    /* Chat Oynasi */
    .chat-window {
        flex-grow: 1;
        padding: 40px;
        background: #FFFFFF;
        /* Oq fon */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    /* Xabarlar Tarixi */
    .message-history {
        height: calc(100% - 160px);
        overflow-y: auto;
        padding: 15px;
        background: #F8F9FA;
        /* Yengil kulrang fon */
        border-radius: 8px;
        margin-bottom: 25px;
    }

    .message {
        padding: 16px;
        background: #E0E0E0;
        /* Kulrang */
        border-radius: 10px;
        margin-bottom: 14px;
        color: #202124;
    }

    .message h6,
    .message p {
        color: #202124;
    }

    /* Tugmalar */
    .btn-success {
        background: #4285F4;
        /* Google Blue */
        border: none;
        padding: 14px 25px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 10px;
        color: #FFFFFF;
        transition: all 0.3s ease;
    }

    /* Tugmalar */
    .btn-danger {
        background: red;
        /* Google Blue */
        border: none;
        padding: 14px 25px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 10px;
        color: #FFFFFF;
        transition: all 0.3s ease;
    }


    .btn-success:hover {
        background: #357AE8;
        /* Google Blue hover */
        transform: scale(1.05);
    }

    .container {
        padding: 30px;
    }
</style>

</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-start align-items-center">
                <a href="main.php" class="me-2"><button class="btn btn-success"><?= $trans['send'] ?></button></a>
                <a href="contacts.php" class="me-2"><button class="btn btn-success"><?= $trans['contacts'] ?></button></a>
                <a href="logout.php" class="btn btn-success"><?= $trans['exit'] ?></a>

                
            </div>
            <div class="main-content">
                <div class="sidebar">
                    <h5><?= $trans['groups'] ?></h5>
                    <form method="POST" id="groupForm">
                        <ul class="list-group">
                            <?php foreach ($contact->getGroups() as $group): ?>
                                <li class="list-group-item group-item <?= $selectedGroupId == $group['id'] ? 'selected' : '' ?>"
                                    data-group-id="<?= $group['id'] ?>"
                                    data-group-title="<?= htmlspecialchars($group['title']) ?>">
                                    <?= htmlspecialchars($group['title']) ?> - <?= htmlspecialchars($group['description']) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <input type="hidden" name="group_id" id="selectedGroupId">
                        <input type="hidden" name="group_title" id="selectedGroupTitle">
                    </form>
                </div>
                <div class="chat-window">
                    <div class="message-history">

                        <form method="post">
                            <input type='hidden' name='groupIdClearHistory' value="<?= $selectedGroupId ?>">
                            <div class="message"><?= $trans['groupHistory'] ?>
                                <button type="submit" class="btn btn-warning"><?= $trans['clear'] ?></button>
                            </div>
                        </form>

                        <?php foreach ($smsService->getGroupSMS($selectedGroupId) as $messages): ?>
                            <div class="message">
                                <h6><?= $messages['message'] ?></h6>
                                <p style="font-size: 14px;">
                                    <?= $messages['created_at'] ?>
                                    <i class="fas fa-check-double text-success"></i>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <form method="POST">
                        <input type='hidden' name='groupId' value="<?= $selectedGroupId ?>">
                        <textarea class="form-control" name="message" rows="4" placeholder="<?= $trans['inputMessage'] ?>" required></textarea>
                        <button type="submit" name="sendSMS" class="btn btn-success mt-2"><?= $trans['send'] ?></button>
                    </form>

                </div>
            </div>
        </div>
    </div>






    <script>
        document.querySelectorAll('.group-item').forEach(item => {
            item.addEventListener('click', function() {
                const groupId = this.getAttribute('data-group-id');
                const groupTitle = this.getAttribute('data-group-title');

                document.getElementById('selectedGroupId').value = groupId;
                document.getElementById('selectedGroupTitle').value = groupTitle;

               

                // Barcha li elementlarini rangini o‘chirish
                document.querySelectorAll('.group-item').forEach(el => el.classList.remove('selected'));

                // Bosilgan li rangini o‘zgartirish
                this.classList.add('selected');

                document.getElementById('groupForm').submit();
            });
        });
    </script>



</body>
<?php include_once 'components/footer.php'; ?>