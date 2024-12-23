<?php

require_once '../config/bootstrap.php';

$trans = require_once "../lang/" . $_SESSION['lang'] . ".php";


if (!$auth->check()) {
    header("Location: /views/login.php");
    exit();
}

// Formani yuborish
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Telefon raqamini qo'shish
    if (isset($_POST['addPhoneNumber'])) {
        $groupId = $_POST['groupId'];
        $phoneNumber = $_POST['phoneNumber'];
        $name = $_POST['phoneName'];

        $contact->addPhoneNumber($groupId, $phoneNumber, $name);  // Telefon raqamini qo'shish
    }

    // Telefon raqamini o'chirish
    if (isset($_POST['removePhoneNumber'])) {
        $number_id = $_POST['number_id'];
        $phoneNumber = $_POST['phoneNumber'];
        if ($contact->removePhoneNumber($number_id, $phoneNumber)) {
            echo 'ochirildi';
        } else {
            echo 'xato';
        }
    }
}
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

    .btn {
        border-radius: 50px;
        /* Yumaloq tugmalar */
        padding: 8px 20px;
        font-size: 1rem;
    }

    .btn-primary {
        background: #4285f4;
        /* Google ko'k rang */
        border: none;
        color: white;
    }

    .btn-danger {
        background: #db4437;
        /* Google qizil rang */
        border: none;
        color: white;
        border-radius: 10px;
    }

    .accordion-button {
        background: #f1f3f4;
        /* Yengil kulrang fon */
        color: #202124;
        font-weight: 500;
        border: none;
        padding: 15px;
        border-radius: 8px;
    }

    .accordion-button:focus {
        box-shadow: none;
    }

    .accordion-item {
        border: none;
    }

    .accordion-body {
        background: #fff;
        color: #202124;
        padding: 20px;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    .list-group-item {
        background: #fafafa;
        border: 1px solid #f1f3f4;
        border-radius: 8px;
        margin-bottom: 10px;
        padding: 12px;
    }

    .form-control {
        border-radius: 30px;
        padding: 10px;
        border: 1px solid #f1f3f4;
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

    .btn-success:hover {
        background: #357AE8;
        /* Google Blue hover */
        transform: scale(1.05);
    }

    .container {
        padding: 30px;
    }
</style>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-start align-items-center">
                <div>
                    <a href="main.php" class="btn btn-success me-2"><?= $trans['send'] ?></a>
                    <a href="contacts.php" class="btn btn-success me-2"><?= $trans['contacts'] ?></a>
                    <a href="logout.php" class="btn btn-success"><?= $trans['exit'] ?></a>
                </div>

            </div>
            <div class="accordion" id="groupAccordion">
                <?php foreach ($contact->getGroups() as $group): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?= $group['id'] ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $group['id'] ?>" aria-expanded="false" aria-controls="collapse<?= $group['id'] ?>">
                                <?= htmlspecialchars($group['title']) ?>
                            </button>
                        </h2>
                        <div id="collapse<?= $group['id'] ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $group['id'] ?>" data-bs-parent="#groupAccordion">
                            <div class="accordion-body">
                                <ul class="list-group mb-3">
                                    <?php foreach ($contact->getNumbersGroup($group['id']) as $phone): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <?= htmlspecialchars($phone['name']) . ' | ' . htmlspecialchars($phone['phone_number']) ?>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="number_id" value="<?= $phone['id'] ?>">
                                                <input type="hidden" name="phoneNumber" value="<?= $phone['phone_number'] ?>">
                                                <button type="submit" name="removePhoneNumber" class="btn btn-danger btn-sm"><?= $trans['delete'] ?></button>
                                            </form>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <form method="POST" class="mt-3">
                                    <input type="hidden" name="groupId" value="<?= $group['id'] ?>">
                                    <input type="text" name="phoneName" class="form-control" placeholder="<?= $trans['contactName'] ?>" required>
                                    <input type="text" name="phoneNumber" class="form-control" placeholder="<?= $trans['contactNumber'] ?>" required>
                                    <button type="submit" name="addPhoneNumber" class="btn btn-success w-100"><?= $trans['add'] ?></button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

 
</body>

<?php include_once 'components/footer.php'; ?>