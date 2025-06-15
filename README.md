🏥 Hospital Appointment System

A comprehensive web-based Hospital Appointment Management System that streamlines patient interactions, doctor appointments, and administrative tasks. This platform provides a smooth experience for both patients and administrators with a clean UI and functional validations.

🌐 Key Features
🏠 Home Page
Image Slideshow showcasing the hospital: operation theatre, reception, hospital building, etc.
Query Section where users can submit their queries (stored in the database and visible to admin).
Embedded Map showing the real-time location of the hospital.

ℹ️ About Page
General information about the hospital's mission, services, and care philosophy.

🛎️Services Page
Highlights 24/7 availability, ambulance facility, surrogacy services.
Displays specialties like enthusiasm, expertise, etc.
Clicking Read More opens a modal with a detailed image and description of each specialty.

👨‍⚕️ Doctors Page
Displays detailed doctor profiles.
Clicking View Profile opens a doctor's resume or full profile view.

📅 Booking Page
Allows patients to book appointments by:
Choosing appointment type.
Selecting doctor based on appointment type.
Viewing available slots (each doctor handles up to 10 patients per day).

Validations include:
Required fields: name, date, etc.
Cannot book appointments for past dates — only today and future dates are allowed.

🔐 Admin Panel
Accessible only after login with correct credentials.

Features:
View Booked Appointments with filters:
Filter by date and appointment type.
Reset Functionality: Admin can clear/reset appointment data.
Doctors Management: View doctor details.
Query Management: View all patient/user queries submitted via home page.

🛠️ Technologies Used
Frontend: HTML, CSS, JavaScript
Backend: PHP 
Database: MySQL 
Others: Google Maps (for location embedding), Bootstrap (for responsive design)

📌 Future Enhancements
Email or SMS notifications after booking.
Doctor availability calendar sync.
Patient login system to view personal history.
Export data (CSV/PDF) for admin records.
