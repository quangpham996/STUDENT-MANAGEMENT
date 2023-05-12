$('button.destroy').click(function (e) {
	e.preventDefault();
	// Lấy giá trị thuộc tính data-href của button được click
	// this là button được click
	var dataUrl = $(this).attr('data-href');
	// cập nhật giá trị cho thuộc tính href của thẻ a trong modal
	$('#exampleModal a').attr('href', dataUrl);
});


$(".form-create-student, .form-edit-student").validate({
	rules: {
		name: {
			required: true,
			maxlength: 50,
			regex: /^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+$/i
		},

		birthday: {
			required: true,
		},

		gender: {
			required: true,
		},

	},
	messages: {
		name: {
			required: 'Vui lòng nhập họ và tên',
			maxlength: 'Vui lòng nhập không quá 50 ký tự',
			regex: 'Vui lòng nhập ký tự thông thường, không có số hoặc ký tự đặc biệt'
		},
		birthday: {
			required: 'Vui lòng nhập ngày sinh',
		},

		gender: {
			required: 'Vui lòng chọn giới tính',
		},

	}
});

$(".form-create-subject, .form-edit-subject").validate({
	rules: {
		name: {
			required: true,
			maxlength: 50
		},

		number_of_credit: {
			required: true,
			number: true,
			digits: true,
			range: [1, 10]
		},

	},
	messages: {
		name: {
			required: 'Vui lòng nhập tên môn học',
			maxlength: 'Vui lòng nhập không quá 50 ký tự',

		},
		number_of_credit: {
			required: 'Vui lòng nhập số tín chỉ',
			number: 'Vui lòng nhập số',
			digits: 'Vui lòng nhập số nguyên',
			range: 'Vui lòng nhập con số từ 1 đến 10'
		},

	}
});

$(".form-create-register").validate({
	rules: {
		student_id: {
			required: true,
		},

		subject_id: {
			required: true,
		},

	},
	messages: {
		student_id: {
			required: 'Vui lòng chọn sinh viên',
		},

		subject_id: {
			required: 'Vui lòng chọn môn học',
		},

	}
});

$(".form-edit-register").validate({
	rules: {
		score: {
			required: true,
			number: true,
			range: [0, 10]
		},

	},
	messages: {
		score: {
			required: 'Vui lòng nhập điểm',
			number: 'Vui lòng nhập con số',
			range: 'Vui lòng nhập con số từ 0 đến 10'
		},

	}
});


$.validator.addMethod(
	"regex",
	function (value, element, regexp) {
		var re = new RegExp(regexp);
		return this.optional(element) || re.test(value);
	},
	"Please check your input."
);

function gotoPage(page) {
	// header('location: url');//giống php
	// mục tiêu là tìm url
	// vd hiện tại url là: http://qlsvmvc.com/?page=1
	const currentURL = window.location.href;
	const obj = new URL(currentURL);
	//url mới là http://qlsvmvc.com/?page=2
	obj.searchParams.set('page', page);
	const newURL = obj.href;
	window.location.href = newURL;
}