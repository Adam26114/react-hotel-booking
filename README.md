Here’s a `README.md` file for your project that includes details about the technologies used, such as CDN for React, Ant Design, and PHP:

---

# Hotel Booking System

This project is a **Hotel Booking System** built using **React** (via CDN), **Ant Design** (via CDN), and **PHP** for backend processing. It allows users to browse available rooms, select dates, and book a room.

---

## **Technologies Used**

### **Frontend**
- **React 18** (via CDN)  
  React is used for building the user interface and managing the application state.  
  CDN Links:  
  ```html
  <script crossorigin src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
  <script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>
  ```

- **Ant Design** (via CDN)  
  Ant Design is used for UI components like cards, buttons, date pickers, and pagination.  
  CDN Links:  
  ```html
  <link href="https://unpkg.com/antd@5.22.2/dist/reset.css" rel="stylesheet">
  <link href="https://unpkg.com/antd@5.22.2/dist/antd.css" rel="stylesheet">
  <script src="https://unpkg.com/antd@5.22.2/dist/antd.min.js"></script>
  ```

- **Tailwind CSS** (via CDN)  
  Tailwind CSS is used for utility-first styling.  
  CDN Link:  
  ```html
  <script src="https://cdn.tailwindcss.com"></script>
  ```

- **Babel** (via CDN)  
  Babel is used for compiling JSX in the browser.  
  CDN Link:  
  ```html
  <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
  ```

- **Day.js** (via CDN)  
  Day.js is used for date manipulation.  
  CDN Link:  
  ```html
  <script src="https://unpkg.com/dayjs@1.11.10/dayjs.min.js"></script>
  ```

---

### **Backend**
- **PHP**  
  PHP is used for processing the booking data on the server side. The booking data is sent to `process-booking.php` via a POST request.

---

## **Features**
1. **Room Listing**  
   - Users can browse available rooms with details like name, description, price, and amenities.
   - Rooms are displayed in a paginated format.

2. **Room Selection**  
   - Users can select a room for booking.

3. **Date Picker**  
   - Users can select check-in and check-out dates using a range picker.

4. **Guest Selection**  
   - Users can specify the number of adults and children.

5. **Booking Summary**  
   - Displays the selected room, total nights, and total amount.

6. **Booking Submission**  
   - Users can submit their booking, which is processed by the PHP backend.

---

## **Folder Structure**
```
project/
├── index.php          # Main entry point for the application
├── process-booking.php # PHP script to handle booking submissions
├── README.md          # Project documentation
```

---

## **How to Run the Project**
1. **Set Up a Local Server**  
   - Use a local server like XAMPP, WAMP, or MAMP to run the PHP code.

2. **Clone the Repository**  
   ```bash
   git clone <repository-url>
   ```

3. **Place the Project in the Server Directory**  
   - Move the project folder to the `htdocs` (for XAMPP) or `www` (for WAMP) directory.

4. **Start the Server**  
   - Start your local server (e.g., Apache from XAMPP).

5. **Access the Application**  
   - Open your browser and navigate to:  
     ```
     http://localhost/project-folder/index.php
     ```

---

## **Customization**
- **Styling**  
  Customize the styles in the `<style>` tag within `index.php` or use Tailwind CSS utility classes.

- **Room Data**  
  Modify the `rooms` array in the React component to add or update room details.

- **PHP Backend**  
  Update `process-booking.php` to handle the booking data as needed (e.g., save to a database).

---

## **Dependencies**
All dependencies are loaded via CDN, so no installation is required.

---

## **License**
This project is open-source and available under the MIT License.

---