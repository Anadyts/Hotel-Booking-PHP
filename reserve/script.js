const today = new Date().toISOString().split('T')[0];
document.getElementById("checkIn").setAttribute("min", today);
document.getElementById("checkOut").setAttribute("min", today);

