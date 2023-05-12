<?php
class StudentController
{
    // Trang chủ (hiển thị danh sách sinh viên)
    function index()
    {
        $studentRepository = new StudentRepository();
        $search = $_GET['search'] ?? null;
        $item_per_page = ITEM_PER_PAGE;
        $page = $_GET['page'] ?? 1;
        // Trả về danh sách sinh viên dạng object
        if ($search) {
            $students = $studentRepository->getByPattern($search, $page, $item_per_page);
            $studentTotals = $studentRepository->getByPattern($search);
        } else {
            $students = $studentRepository->getAll($page, $item_per_page);
            $studentTotals = $studentRepository->getAll();
        }

        // ceil(12/5) => 3
        $totalPage = ceil(count($studentTotals) / $item_per_page);

        require 'view/student/index.php';
    }

    // Hiển thị form tạo sinh viên
    function create()
    {
        require 'view/student/create.php';
    }

    function store()
    {
        $name = $_POST['name'];
        $data = $_POST;
        $studentRepository = new StudentRepository();
        if ($studentRepository->save($data)) {
            $_SESSION['success'] = "Đã tạo sinh viên $name thành công";
            header('location: /');
            exit;
        }

        $_SESSION['error'] = $studentRepository->error;
        header('location: /');
    }

    function edit()
    {
        $id = $_GET['id'];
        $studentRepository = new StudentRepository();
        $student = $studentRepository->find($id);

        require 'view/student/edit.php';
    }

    function update()
    {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $birthday = $_POST['birthday'];
        $gender = $_POST['gender'];

        $studentRepository = new StudentRepository();
        $student = $studentRepository->find($id);

        // Cập nhật dữ liệu vào object
        $student->name = $name;
        $student->birthday = $birthday;
        $student->gender = $gender;

        // Lưu xuống database
        if ($studentRepository->update($student)) {
            $_SESSION['success'] = "Đã cập nhật sinh viên $name thành công";
            header('location: /');
            exit;
        }

        $_SESSION['error'] = $studentRepository->error;
        header('location: /');
    }

    function destroy()
    {
        $id = $_GET['id'];
        $studentRepository = new StudentRepository();

        // Lấy name của sinh viên muốn xóa
        $student = $studentRepository->find($id);
        $name = $student->name;

        // Nếu sinh viên đã đăng ký môn học rồi thì không thể xóa
        $registerRepository = new RegisterRepository();
        $registers = $registerRepository->getByStudentId($student->id);
        if (count($registers) > 0) {
            $_SESSION['error'] = "Sinh viên $name đã đăng ký môn học, không thể xóa";
            header('location: /');
            exit;
        }

        // Xóa sinh viên ở database
        if ($studentRepository->destroy($id)) {
            $_SESSION['success'] = "Đã xóa sinh viên $name thành công";
            header('location: /');
            exit;
        }

        $_SESSION['error'] = $studentRepository->error;
        header('location: /');
    }
}
