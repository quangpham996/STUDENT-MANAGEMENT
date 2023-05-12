<?php require 'layout/header.php' ?>
<h1>Danh sách sinh viên đăng ký môn học</h1>
<a href="?c=register&a=create" class="btn btn-info">Add</a>
<?php require 'layout/search.php' ?>
<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Mã SV</th>
            <th>Tên SV</th>
            <th>Mã MH</th>
            <th>Tên MH</th>
            <th>Điểm</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $stt = 0;
        foreach ($registers as $register) :
            $stt++;
        ?>
        <tr>
            <td><?= $stt ?></td>
            <td><?= $register->student_id ?></td>
            <td><?= $register->student_name ?></td>
            <td><?= $register->subject_id ?></td>
            <td><?= $register->subject_name ?></td>
            <td><?= $register->score ?></td>
            <td><a class="btn btn-warning btn-sm" href="?c=register&a=edit&id=<?= $register->id ?>">Sửa</a></td>

            <td>

                <button type="button" data-href="?c=register&a=destroy&id=<?= $register->id ?>"
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
    <span>Số lượng: <?= count($registers) ?></span>
</div>
<?php require 'layout/footer.php' ?>