
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Consultation</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .card-header {
            background-color: #518071;
            color: #fff;
        }

        .btn-primary {
            background-color: #00c896;
            border-color: #00c896;
        }

        .btn-primary:hover {
            background-color: #518071;
            border-color: #518071;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Book Consultation
            </div>
            <div class="card-body">
                <form action="#" method="post">
                    <!-- Patient Selection -->
                    <div class="form-group">
                        <label for="patient">Select Patient</label>
                        <select class="form-control" id="patient" name="patient" required>
                            <option value="">-- Select Patient --</option>
                            <!-- Populate with patient options dynamically -->
                        </select>
                    </div>

                    <!-- Consultation Details -->
                    <div class="form-group">
                        <label for="reason">Reason for Consultation</label>
                        <textarea class="form-control" id="reason" name="reason" rows="4" placeholder="Enter reason for consultation" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="doctor">Preferred Doctor (Optional)</label>
                        <select class="form-control" id="doctor" name="doctor">
                            <option value="">-- Select Doctor --</option>
                            <!-- Populate with doctor options dynamically -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="timeslot">Preferred Time Slot (Optional)</label>
                        <input type="datetime-local" class="form-control" id="timeslot" name="timeslot">
                    </div>

                    <div class="form-group">
                        <label for="priority">Priority Level</label>
                        <select class="form-control" id="priority" name="priority">
                            <option value="Routine">Routine</option>
                            <option value="Urgent">Urgent</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="notes">Additional Notes (Optional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Enter any additional notes"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Book Consultation</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>