@extends('adminlte::page')

@section('content')

@if (session('status'))
        <div class="alert alert-danger">
            {{ session('status') }}
        </div>
    @endif

<h1>Thêm sinh viên đã đăng ký môn thi </h1>
<hr>
<form action="{{route('admin.monthis.saveStudent', $monthiId)}}" method="POST">
@csrf
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="form-group row">
                <label for="studentid" class="col-md-4 col-form-label text-md-right">{{ __('Mã sinh viên') }}</label>
                <div class="col-md-6 autocomplete">
                    <input id="studentId" type="text" class="form-control @error('studentId') is-invalid @enderror" name="studentId" required autocomplete="studentId" autofocus>
                </div>
                <input type="button" value="Tìm kiếm" id="search" class="btn btn-primary">
            </div>
            <div class="col-md-5">
                <label for="eligible">Đủ điều kiện:</label> <input type="radio" name="eligible" value=1 required> 
            </div>
            <div class="col-md-3">
            <label for="eligible">Không đủ điều kiện:</label> <input type="radio" name="eligible" value=0 required> 
            </div> <br>
            <h4 style="text-align: center">-----------------THÔNG TIN SINH VIÊN-------------------</h4>
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Tên sinh viên') }}</label>
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" disabled>
                </div>
            </div>

            <div class="form-group row">
                <label for="subjectid" class="col-md-4 col-form-label text-md-right">{{ __('Tên lớp') }}</label>

                <div class="col-md-6">
                    <input id="class" type="text" class="form-control @error('subjectid') is-invalid @enderror" name="class" value="{{ old('class') }}" required autocomplete="class" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="dob" class="col-md-4 col-form-label text-md-right">{{ __('Ngày tháng năm sinh') }}</label>

                <div class="col-md-6">
                    <input id="dob" type="text" class="form-control @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob') }}" required autocomplete="dob" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                <div class="col-md-6">
                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="dob" disabled>
                </div>
            </div>
            <input type="submit" value="Lưu" class="btn btn-submit">
        </div>
    </div>
</div>
</form>
@endsection

@section('css')
<style>

    .autocomplete {
    /*the container must be positioned relative:*/
        position: relative;
        display: inline-block;
    }
    input {
        border: 1px solid transparent;
        background-color: #f1f1f1;
        padding: 10px;
        font-size: 16px;
    }

    input[type=submit] {
        background-color: DodgerBlue;
        color: #fff;
    }
    .autocomplete-items {
        margin: 0px 15px 0px 15px;
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        /*position the autocomplete items to be the same width as the container:*/
        top: 100%;
        left: 0;
        right: 0;
    }
    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d4;
    }
    .autocomplete-items div:hover {
    /*when hovering an item:*/
        background-color: #e9e9e9;
    }
    .autocomplete-active {
    /*when navigating through the items using the arrow keys:*/
        background-color: DodgerBlue !important;
        color: #ffffff;
    }
</style>
@stop

@section('js')
<script>
function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
      x[i].parentNode.removeChild(x[i]);
    }
  }
}
/*execute a function when someone clicks in the document:*/
document.addEventListener("click", function (e) {
    closeAllLists(e.target);
});
}

$.ajax({
    url: "/api/sinhvien/all",
    success: function(students) {
        studentIds = students.map(function(student) {
            return student['studentId'];
        });
        autocomplete(document.getElementById("studentId"), studentIds);
    }
});
$("#search").click(function() {
    studentId = document.getElementById('studentId').value;
    $.ajax({
        url: "/api/sinhvien/"+studentId,
        success: function(student) {
            if (student.length == 0)
                alert("Không tìm thấy sinh viên");
            else {
                student = student[0];
                document.getElementById("name").value = student['name'];
                document.getElementById("class").value = student['class'];
                document.getElementById("dob").value = student['dob'];
                document.getElementById("email").value = student['email'];
            }
        }
    });
});
</script>
@stop
