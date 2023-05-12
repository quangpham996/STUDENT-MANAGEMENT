<?php
// Truy cập xuống database 
class RegisterRepository
{
    public $error;
    // Trả về danh sách bao gồm các đối tượng sinh viên
    function fetch($cond = null, $page = null, $item_per_page = null)
    {
        // bên trong hàm không nhìn thấy biến bên ngoài hàm
        // để bên trong hàm nhìn thấy biến bên ngoài hàm phải dung từ khóa global
        global $conn;
        $sql = "SELECT register.*, student.name AS student_name, subject.name AS subject_name FROM register
            JOIN student ON register.student_id = student.id
            JOIN subject ON register.subject_id = subject.id
        ";
        if ($cond) {
            $sql .= " WHERE $cond";
            //SELECT * FROM register WHERE student_id LIKE '%ty%'
        }
        if ($page && $item_per_page) {
            $index = ($page - 1) * $item_per_page;
            $sql .= " LIMIT $index , $item_per_page";
        }
        $result = $conn->query($sql);
        $registers = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $student_id = $row['student_id'];
                $subject_id = $row['subject_id'];
                $score = $row['score'];
                $student_name = $row['student_name'];
                $subject_name = $row['subject_name'];
                $register = new Register($id, $student_id, $subject_id, $score, $student_name, $subject_name);
                // [] bên trái dấu bằng nghĩa là thêm 1 phần tử vào cuối danh sách
                $registers[] = $register;
            }
        }
        return $registers;
    }

    function getByPattern($search = null, $page = null, $item_per_page = null)
    {
        $cond = "student_id LIKE '%$search%'";
        $registers = $this->fetch($cond, $page, $item_per_page);
        return $registers;
    }

    function getAll($page = null, $item_per_page = null)
    {
        $registers = $this->fetch(null, $page, $item_per_page);
        return $registers;
    }

    function save($data)
    {
        global $conn;
        //Thêm đăng ký môn học vào database
        $student_id = $data['student_id'];
        $subject_id = $data['subject_id'];
        $sql = "INSERT INTO register (student_id, subject_id) VALUES('$student_id', '$subject_id')";

        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }

    function find($id)
    {
        $cond = "register.id=$id";
        $registers = $this->fetch($cond);
        // $register = $registers[0];
        $register = current($registers); //lấy phần tử đầu tiên
        return $register;
    }

    function update($register)
    {
        // chỉ cập nhật điểm
        global $conn;
        $score = $register->score;

        $id = $register->id;
        $sql = "UPDATE register SET score=$score WHERE id=$id";
        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }

    function destroy($id)
    {
        global $conn;
        $sql = "DELETE FROM register WHERE id=$id";
        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }

    function getByStudentId($studentId)
    {
        $cond = "student_id=$studentId";
        $registers = $this->fetch($cond);
        return $registers;
    }

    function getBySubjectId($subjectId)
    {
        $cond = "subject_id=$subjectId";
        $registers = $this->fetch($cond);
        return $registers;
    }
}