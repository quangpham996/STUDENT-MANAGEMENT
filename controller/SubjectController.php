<?php
class SubjectController
{
    // Trang chủ (hiển thị danh sách môn học)
    function index()
    {
        $subjectRepository = new SubjectRepository();
        $search = $_GET['search'] ?? null;

        $page = $_GET['page'] ?? 1;
        $item_per_page = ITEM_PER_PAGE;



        // Trả về danh sách môn học dạng object
        if ($search) {
            $subjects = $subjectRepository->getByPattern($search, $page, $item_per_page);
            $subjectsTotal = $subjectRepository->getByPattern($search);
        } else {
            $subjects = $subjectRepository->getAll($page, $item_per_page);
            $subjectsTotal = $subjectRepository->getAll();
        }
        $totalPage = ceil(count($subjectsTotal) / $item_per_page);

        require 'view/subject/index.php';
    }

    // Hiển thị form tạo môn học
    function create()
    {
        require 'view/subject/create.php';
    }

    function store()
    {
        $name = $_POST['name'];
        $data = $_POST;
        $subjectRepository = new SubjectRepository();
        if ($subjectRepository->save($data)) {
            $_SESSION['success'] = "Đã tạo môn học $name thành công";
            header('location: /?c=subject');
            exit;
        }

        $_SESSION['error'] = $subjectRepository->error;
        header('location: /?c=subject');
    }

    function edit()
    {
        $id = $_GET['id'];
        $subjectRepository = new SubjectRepository();
        $subject = $subjectRepository->find($id);

        require 'view/subject/edit.php';
    }

    function update()
    {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $number_of_credit = $_POST['number_of_credit'];

        $subjectRepository = new SubjectRepository();
        $subject = $subjectRepository->find($id);

        // Cập nhật dữ liệu vào object
        $subject->name = $name;
        $subject->number_of_credit = $number_of_credit;

        // Lưu xuống database
        if ($subjectRepository->update($subject)) {
            $_SESSION['success'] = "Đã cập nhật môn học $name thành công";
            header('location: /?c=subject');
            exit;
        }

        $_SESSION['error'] = $subjectRepository->error;
        header('location: /?c=subject');
    }

    function destroy()
    {
        $id = $_GET['id'];
        $subjectRepository = new SubjectRepository();

        // Lấy name của môn học muốn xóa
        $subject = $subjectRepository->find($id);
        $name = $subject->name;

        // Nếu môn học đã được sinh viên đăng ký, không thể xóa
        $registerRepository = new RegisterRepository();
        $registers = $registerRepository->getBySubjectId($subject->id);
        if (count($registers) > 0) {
            $_SESSION['error'] = "Môn học $name đã được sinh viên đăng ký, không thể xóa";
            header('location: /?c=subject');
            exit;
        }


        // Xóa môn học ở database
        if ($subjectRepository->destroy($id)) {
            $_SESSION['success'] = "Đã xóa môn học $name thành công";
            header('location: /?c=subject');
            exit;
        }

        $_SESSION['error'] = $subjectRepository->error;
        header('location: /?c=subject');
    }
}