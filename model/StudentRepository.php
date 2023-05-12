<?php
// Truy cập xuống database 
class StudentRepository
{
    public $error;
    // Trả về danh sách bao gồm các đối tượng sinh viên
    function fetch($cond = null, $page = null, $item_per_page = null)
    {
        // bên trong hàm không nhìn thấy biến bên ngoài hàm
        // để bên trong hàm nhìn thấy biến bên ngoài hàm phải dung từ khóa global
        global $conn;
        $sql = "SELECT * FROM student";
        if ($cond) {
            $sql .= " WHERE $cond";

            //SELECT * FROM student WHERE name LIKE '%ty%'

        }
        // Phân trang
        if ($page && $item_per_page) {
            $index = ($page - 1) * $item_per_page;
            $sql .= " LIMIT $index, $item_per_page";
        }
        $result = $conn->query($sql);
        $students = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $name = $row['name'];
                $birthday = $row['birthday'];
                $gender = $row['gender'];
                $student = new Student($id, $name, $birthday, $gender);
                // [] bên trái dấu bằng nghĩa là thêm 1 phần tử vào cuối danh sách
                $students[] = $student;
            }
        }
        return $students;
    }

    function getByPattern($search = null, $page = null, $item_per_page = null)
    {
        $cond = "name LIKE '%$search%'";
        $students = $this->fetch($cond, $page, $item_per_page);
        return $students;
    }

    function getAll($page = null, $item_per_page = null)
    {
        $students = $this->fetch(null, $page, $item_per_page);
        return $students;
    }

    function save($data)
    {
        global $conn;
        //Thêm 1 sinh viên ở database
        $name = $data['name'];
        $birthday = $data['birthday'];
        $gender = $data['gender'];
        $sql = "INSERT INTO student (name, birthday, gender) VALUES('$name', '$birthday', '$gender')";

        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }

    function find($id)
    {
        $cond = "id=$id";
        $students = $this->fetch($cond);
        // $student = $students[0];
        $student = current($students); //lấy phần tử đầu tiên
        return $student;
    }

    function update($student)
    {
        global $conn;
        $name = $student->name;
        $birthday = $student->birthday;
        $gender = $student->gender;
        $id = $student->id;
        $sql = "UPDATE student SET name='$name', birthday='$birthday', gender='$gender' WHERE id=$id";
        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }

    function destroy($id)
    {
        global $conn;
        $sql = "DELETE FROM student WHERE id=$id";
        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }
}