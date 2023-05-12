<?php
// Truy cập xuống database 
class SubjectRepository
{
    public $error;
    // Trả về danh sách bao gồm các đối tượng sinh viên
    function fetch($cond = null, $page = null, $item_per_page = null)
    {
        // bên trong hàm không nhìn thấy biến bên ngoài hàm
        // để bên trong hàm nhìn thấy biến bên ngoài hàm phải dung từ khóa global
        global $conn;
        $sql = "SELECT * FROM subject";
        if ($cond) {
            $sql .= " WHERE $cond";
            //SELECT * FROM subject WHERE name LIKE '%ty%'
        }

        if ($page && $item_per_page) {
            $index = ($page - 1) * $item_per_page;
            $sql .= " LIMIT $index , $item_per_page";
        }



        $result = $conn->query($sql);
        $subjects = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $name = $row['name'];
                $number_of_credit = $row['number_of_credit'];
                $subject = new Subject($id, $name, $number_of_credit);
                // [] bên trái dấu bằng nghĩa là thêm 1 phần tử vào cuối danh sách
                $subjects[] = $subject;
            }
        }
        return $subjects;
    }

    function getByPattern($search = null, $page = null, $item_per_page = null)
    {
        $cond = "name LIKE '%$search%'";
        $subjects = $this->fetch($cond, $page, $item_per_page);
        return $subjects;
    }

    function getAll($page = null, $item_per_page = null)
    {
        $subjects = $this->fetch(null, $page, $item_per_page);
        return $subjects;
    }

    function save($data)
    {
        global $conn;
        //Thêm 1 sinh viên ở database
        $name = $data['name'];
        $number_of_credit = $data['number_of_credit'];
        $sql = "INSERT INTO subject (name, number_of_credit) VALUES('$name', '$number_of_credit')";

        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }

    function find($id)
    {
        $cond = "id=$id";
        $subjects = $this->fetch($cond);
        // $subject = $subjects[0];
        $subject = current($subjects); //lấy phần tử đầu tiên
        return $subject;
    }

    function update($subject)
    {
        global $conn;
        $name = $subject->name;
        $number_of_credit = $subject->number_of_credit;

        $id = $subject->id;
        $sql = "UPDATE subject SET name='$name', number_of_credit='$number_of_credit' WHERE id=$id";
        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }

    function destroy($id)
    {
        global $conn;
        $sql = "DELETE FROM subject WHERE id=$id";
        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }
}