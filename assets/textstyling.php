<style>

        .meter {
                    display: block;
                    margin-bottom: 80px; /* Spacing between meters */
                    margin-left: 24%;
                }


        .custom-button-container {
            position: absolute;
            top: 0;
            left: 0;
            margin-top: 1rem;
            margin-left: 1rem;
        }
        .schaal-container {
            position: relative;
            width: 300px;
            height: 300px;
            margin: 50px auto;
        }

        .schaal {
            border-radius: 50%;
            background: conic-gradient(
                #e74c3c 0% 33%,     /* Rood: Slecht */
                #f39c12 33% 66%,    /* Oranje: Gemiddeld */
                #2ecc71 66% 100%    /* Groen: Goed */
            );
        }

        .pijl {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 10px;
            height: 100px;
            background-color: #3498db;
            border-radius: 5px;
            transform-origin: 50% 100%;
            transition: transform 0.5s ease-in-out;
        }

        .waarde {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

.centered-text {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
}

.green-background {
  background-color: gray;
  padding: 20px;
  color: white; /* Set text color to white for better visibility */
  border-radius: 10px; /* Rounded corners for the box */
}

.centered-form {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
}

/* Your existing styles */
.form-control {
  width: 300px; /* Adjust width as needed */
  padding: 10px;
  margin: 5px;
  border: 1px solid #ccc;
  border-radius: 5px;
  outline: none;
}

/* New style for focus state */
.form-control:focus {
  border-color: green;
  box-shadow: 0 0 5px rgba(0, 255, 0, 0.5); /* Green shadow */
}

.btn {
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}


</style>