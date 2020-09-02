<?php include('common/header.php') ;?>
    <div class="container pt-4 pb-1">
        <h1>Book Appointment</h1>
        <hr />
        <form method="post" id="savestudent" action="savestudent.php">
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="appointment-date">Appointment Date </label>

              <input
                type="text"
                class="form-control datepicker"
                name="appointment_date"
                id="appointment-date"
                placeholder="Appointment Date"
              />
              <span id="appointment-error" class="error"></span>
            </div>
            <div class="form-group col-md-3">
              <label for="location">Location</label>
              <select
                name="location"
                id="student-location"
                class="custom-select form-control mb-3"
              >
                <option value="">--- Select One ---</option>
              </select>
              <span id="location-error" class="error"></span>
            </div>

            <div class="form-check form-check-inline">
              <input
                class="form-check-input interview_type"
                type="radio"
                name="location_type"
                id="ghse"
                value="0"
              />
              <label class="form-check-label" for="location_type">QHSE</label>
            </div>
            <div class="form-check form-check-inline">
              <input
                class="form-check-input interview_type"
                type="radio"
                name="location_type"
                id="zoom"
                value="1"
              />
              <label class="form-check-label" for="zoom">Zoom Call</label>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="time-slot">Select Time slot</label>
              <select
                name="time_slot"
                id="time-slot"
                class="custom-select form-control mb-3"
              >
                <option value="">--- Select One ---</option>
              </select>
              <span id="timeslot-error" class="error"></span>
            </div>
            <div class="form-group col-md-5">
              <label for="end-time">Reason</label>
              <select
                name="reason"
                id="student-reason"
                class="custom-select form-control mb-3"
              >
                <option value="">--- Select One ---</option>
              </select>
              <span id="reason-error" class="error"></span>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="student-name">Name</label>
              <input
                type="text"
                class="form-control"
                name="student_name"
                id="student-name"
                placeholder="Name"
              />
              <span id="name-error" class="error"></span>
            </div>
            <div class="form-group col-md-5">
              <label for="student-mobile">Mobile Number</label>
              <input
                type="text"
                class="form-control"
                name="student_mobile"
                id="student-mobile"
                placeholder="Mobile number"
              />
              <span id="mobile-error" class="error"></span>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="student-email">Email Id</label>
              <input
                type="text"
                class="form-control"
                name="student_email"
                id="student-email"
                placeholder="Email"
              />
              <span id="email-error" class="error"></span>
            </div>
            <div class="form-group col-md-5">
              <label for="student-number">Student Number</label>
              <input
                type="text"
                class="form-control"
                name="student_number"
                id="student-number"
                placeholder="Sutudent Id number"
              />
              <span id="number-error" class="error"></span>
            </div>
          </div>
          <button
            type="button"
            name="save"
            id="save-btn"
            class="btn btn-success btn-lg"
          >
            Save
          </button>
          <span id="error-booking" class="error"></span>
        </form>
      </div>
<?php include('common/footer.php');
?>
