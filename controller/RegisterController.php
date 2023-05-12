<?php
class RegisterController
{
    // Trang chủ (hiển thị danh sách môn học)
    function index()
    {
        $registerRepository = new RegisterRepository();
        $search = $_GET['search'] ?? null;
        $page = $_GET['page'] ?? 1;
        $item_per_page = ITEM_PER_PAGE;

        // Trả về danh sách môn học dạng object
        if ($search) {
            $registers = $registerRepository->getByPattern($search, $page, $item_per_page);
            $registersTotal = $registerRepository->getByPattern($search);
        } else {
            $registers = $registerRepository->getAll($page, $item_per_page);
            $registersTotal = $registerRepository->getAll();
        }

        $totalPage = ceil(count($registersTotal) / $item_per_page);
        require 'view/register/index.php';
    }

    // Hiển thị form tạo môn học
    function create()
    {
        // lấy danh sách sinh viên đổ qua view
        $studentRepository = new StudentRepository();
        $students = $studentRepository->getAll();

        // Lấy danh sách môn học đổ qua view
        $subjectRepository = new SubjectRepository();
        $subjects = $subjectRepository->getAll();

        require 'view/register/create.php';
    }

    function store()
    {
        $data = $_POST;
        // Lấy tên sinh viên
        $student_id = $data['student_id'];
        $studentRepository = new StudentRepository();
        $student = $studentRepository->find($student_id);
        $student_name = $student->name;

        // Lấy tên môn học
        $subject_id = $data['subject_id'];
        $subjectRepository = new SubjectRepository();
        $subject = $subjectRepository->find($subject_id);
        $subject_name = $subject->name;

        $registerRepository = new RegisterRepository();
        if ($registerRepository->save($data)) {
            $_SESSION['success'] = "Sinh viên $student_name đăng ký môn học $subject_name thành công";
            header('location: /?c=register');
            exit;
        }

        $_SESSION['error'] = $registerRepository->error;
        header('location: /?c=register');
    }

    function edit()
    {
        $id = $_GET['id'];
        $registerRepository = new RegisterRepository();
        $register = $registerRepository->find($id);

        require 'view/register/edit.php';
    }

    function update()
    {
        $id = $_POST['id'];
        $score = $_POST['score'];

        $registerRepository = new RegisterRepository();
        $register = $registerRepository->find($id);
        $student_name = $register->student_name;
        $subject_name = $register->subject_name;
        // Cập nhật dữ liệu vào object
        $register->score = $score;

        // Lưu xuống database
        if ($registerRepository->update($register)) {
            $_SESSION['success'] = "Sinh viên $student_name thi môn $subject_name được $score điểm";
            header('location: /?c=register');
            exit;
        }

        $_SESSION['error'] = $registerRepository->error;
        header('location: /?c=register');
    }

    function destroy()
    {
        $id = $_GET['id'];
        $registerRepository = new RegisterRepository();

        // Lấy student_id của môn học muốn xóa
        $register = $registerRepository->find($id);
        $student_name = $register->student_name;
        $subject_name = $register->subject_name;

        // Xóa môn học ở database
        if ($registerRepository->destroy($id)) {
            $_SESSION['success'] = "Hủy sinh viên $student_name đăng ký môn học $subject_name thành công";
            header('location: /?c=register');
            exit;
        }

        $_SESSION['error'] = $registerRepository->error;
        header('location: /?c=register');
    }
}