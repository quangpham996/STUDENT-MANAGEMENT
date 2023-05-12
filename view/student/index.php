<?php require 'layout/header.php' ?>
<h1>Danh sách sinh viên</h1>
<a href="?a=create" class="btn btn-info">Add</a>
<?php require 'layout/search.php' ?>
<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Mã SV</th>
            <th>Tên</th>
            <th>Ngày Sinh</th>
            <th>Giới Tính</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $stt = 0;
        foreach ($students as $student) :
            $stt++;
        ?>
        <tr>
            <td><?= $stt ?></td>
            <td><?= $student->id ?></td>
            <td><?= $student->name ?></td>
            <td><?= $student->birthday ?></td>
            <td><?= $student->gender ?></td>
            <td><a class="btn btn-warning btn-sm" href="?a=edit&id=<?= $student->id ?>">Sửa</a></td>

            <td>

                <button type="button" data-href="?a=destroy&id=<?= $student->id ?>"
                    class="btn btn-danger btn-sm destroy" data-toggle="modal" data-target="#exampleModal">
                    Xóa
                </button>

            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php require 'layout/pagination.php' ?>
<div>
    <span>Số lượng: <?= count($students) ?></span>
</div>
<?php require 'layout/footer.php' ?>