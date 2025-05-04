<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Healthcare Chatbot</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
  <style>
    /* Modern Healthcare Chatbot CSS */
    :root {
      --primary-color: #5a67d8;
      --primary-light: #818cf8;
      --primary-dark: #4c51bf;
      --secondary-color: #4fd1c5;
      --text-dark: #2d3748;
      --text-medium: #4a5568;
      --text-light: #718096;
      --bg-light: #f7fafc;
      --white: #ffffff;
      --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.08);
      --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
      --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
      --radius-sm: 8px;
      --radius-md: 12px;
      --radius-lg: 16px;
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: "Poppins", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
        Oxygen, Ubuntu, Cantarell, sans-serif;
    }

    body {
      background-color: var(--bg-light);
    }

    /* Chatbot Toggle Button */
    .chatbot-toggle {
      position: fixed;
      bottom: 30px;
      right: 30px;
      z-index: 1000;
      width: 60px;
      height: 60px;
      background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
      color: var(--white);
      border: none;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: var(--shadow-lg);
      cursor: pointer;
      transition: var(--transition);
    }

    .chatbot-toggle:hover {
      transform: scale(1.1);
      box-shadow: 0 8px 25px rgba(90, 103, 216, 0.3);
    }

    .chatbot-toggle .bot-avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid var(--white);
    }

    /* Chatbot Container */
    .chatbot {
      position: fixed;
      bottom: 100px;
      right: 30px;
      width: 380px;
      height: 580px;
      max-height: 80vh;
      background: var(--white);
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-lg);
      overflow: hidden;
      display: none;
      flex-direction: column;
      transform: translateY(10px);
      opacity: 0;
      transition: var(--transition);
      z-index: 1000;
    }

    .show-chatbot .chatbot {
      display: flex;
      transform: translateY(0);
      opacity: 1;
    }

    /* Chatbot Header */
    .chatbot header {
      background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
      padding: 16px 20px;
      text-align: center;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
    }

    .chatbot header h2 {
      color: var(--white);
      font-size: 1.25rem;
      font-weight: 600;
      letter-spacing: 0.3px;
    }

    /* Chatbox Area */
    .chatbot .chatbox {
      flex: 1;
      overflow-y: auto;
      padding: 20px;
      background-color: var(--bg-light);
      scroll-behavior: smooth;
    }

    /* Custom Scrollbar */
    .chatbox::-webkit-scrollbar {
      width: 6px;
    }

    .chatbox::-webkit-scrollbar-track {
      background: transparent;
    }

    .chatbox::-webkit-scrollbar-thumb {
      background: rgba(0, 0, 0, 0.1);
      border-radius: 3px;
    }

    /* Chat Messages */
    .chatbox .chat {
      display: flex;
      margin-bottom: 16px;
      animation: fadeIn 0.3s ease forwards;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .chatbox .chat p {
      max-width: 80%;
      padding: 12px 16px;
      border-radius: var(--radius-md);
      font-size: 0.95rem;
      line-height: 1.5;
      word-break: break-word;
      white-space: pre-wrap;
      box-shadow: var(--shadow-sm);
    }

    /* Incoming Messages (Bot) */
    .chatbox .incoming {
      align-items: flex-start;
    }

    .chatbox .incoming p {
      color: var(--text-dark);
      background: var(--white);
      border-radius: 0 var(--radius-md) var(--radius-md) var(--radius-md);
      margin-left: 10px;
      border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .chatbox .incoming span {
      height: 36px;
      width: 36px;
      background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--white);
      border-radius: 50%;
      font-size: 18px;
      flex-shrink: 0;
    }

    /* Outgoing Messages (User) */
    .chatbox .outgoing {
      justify-content: flex-end;
    }

    .chatbox .outgoing p {
      color: var(--white);
      background: linear-gradient(135deg, var(--primary-light), var(--primary-color));
      border-radius: var(--radius-md) 0 var(--radius-md) var(--radius-md);
    }

    /* Chat Input Area */
    .chatbot .chat-input {
      display: flex;
      gap: 10px;
      width: 100%;
      background: var(--white);
      padding: 16px 20px;
      border-top: 1px solid rgba(0, 0, 0, 0.08);
      align-items: center;
    }

    .chat-input textarea {
      flex: 1;
      min-height: 55px;
      max-height: 120px;
      border: 1px solid rgba(0, 0, 0, 0.1);
      border-radius: var(--radius-md);
      outline: none;
      font-size: 0.95rem;
      resize: none;
      padding: 12px 16px;
      transition: var(--transition);
      background: var(--bg-light);
      color: var(--text-dark);
    }

    .chat-input textarea:focus {
      border-color: var(--primary-light);
      box-shadow: 0 0 0 3px rgba(90, 103, 216, 0.1);
    }

    .chat-input span {
      color: var(--primary-color);
      font-size: 1.5rem;
      cursor: pointer;
      height: 45px;
      width: 45px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      transition: var(--transition);
      background: transparent;
    }

    .chat-input span:hover {
      background: rgba(90, 103, 216, 0.1);
      transform: scale(1.05);
    }

    .chat-input textarea:valid~span {
      visibility: visible;
      color: var(--primary-color);
    }

    /* Typing Indicator */
    .typing-indicator {
      display: inline-flex;
      padding: 12px 16px;
      background: var(--white);
      border-radius: 0 var(--radius-md) var(--radius-md) var(--radius-md);
      margin-left: 46px;
      border: 1px solid rgba(0, 0, 0, 0.05);
      align-items: center;
      gap: 4px;
    }

    .typing-indicator span {
      height: 8px;
      width: 8px;
      background: var(--primary-light);
      border-radius: 50%;
      display: inline-block;
      opacity: 0.4;
    }

    .typing-indicator span:nth-child(1) {
      animation: typingPulse 1s infinite;
    }

    .typing-indicator span:nth-child(2) {
      animation: typingPulse 1s infinite 0.2s;
    }

    .typing-indicator span:nth-child(3) {
      animation: typingPulse 1s infinite 0.4s;
    }

    @keyframes typingPulse {
      0%,
      100% {
        opacity: 0.4;
        transform: translateY(0);
      }
      50% {
        opacity: 1;
        transform: translateY(-2px);
      }
    }

    /* Doctor Cards Styling */
    .doctor-card {
      margin-bottom: 16px;
      padding: 16px;
      border-radius: var(--radius-md);
      background: var(--white);
      box-shadow: var(--shadow-sm);
      transition: var(--transition);
      display: flex;
      flex-direction: column;
      gap: 12px;
      border: 1px solid rgba(0, 0, 0, 0.08);
      overflow: hidden;
    }

    .doctor-card:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow-md);
      border-color: var(--primary-light);
      background: linear-gradient(0deg, var(--bg-light), var(--white));
    }

    .doctor-card a {
      display: flex;
      align-items: center;
      gap: 12px;
      font-weight: 600;
      font-size: 1.1rem;
      color: var(--primary-dark);
      text-decoration: none;
      padding: 8px 12px;
      border-radius: var(--radius-sm);
      transition: var(--transition);
      background: rgba(90, 103, 216, 0.05);
      white-space: normal;
      overflow-wrap: break-word;
    }

    .doctor-card a:hover {
      background: rgba(90, 103, 216, 0.15);
      color: var(--primary-color);
      transform: scale(1.02);
    }

    .doctor-card .doctor-specialty {
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 0.9rem;
      color: var(--text-medium);
      padding: 8px 12px;
      border-radius: var(--radius-sm);
      background: var(--bg-light);
      border-top: 1px solid rgba(0, 0, 0, 0.05);
      white-space: normal;
      overflow-wrap: break-word;
    }

    .doctor-card .material-symbols-outlined {
      font-size: 1.3rem;
      color: var(--primary-light);
      flex-shrink: 0;
    }

    .doctor-card .doctor-specialty span {
      white-space: normal;
      overflow-wrap: break-word;
      max-width: 85%;
    }

    /* Book Appointment Link */
    .book-appointment {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 8px 16px;
      background: var(--primary-color);
      color: var(--white);
      border-radius: var(--radius-sm);
      text-decoration: none;
      font-weight: 500;
      font-size: 0.9rem;
      transition: var(--transition);
      justify-content: center;
      white-space: normal;
      overflow-wrap: break-word;
      width: 100%;
      text-align: center;
    }

    .book-appointment:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: var(--shadow-sm);
    }

    /* Responsive Design */
    @media (max-width: 500px) {
      .chatbot {
        right: 15px;
        bottom: 15px;
        width: calc(100% - 30px);
        height: calc(100% - 80px);
        max-height: none;
        border-radius: var(--radius-lg);
      }

      .chatbot-toggle {
        bottom: 20px;
        right: 20px;
      }

      .chatbot .chatbox {
        padding: 15px;
      }

      .chatbox .chat p {
        font-size: 0.9rem;
        padding: 10px 14px;
      }

      .doctor-card {
        padding: 12px;
        margin-bottom: 12px;
        gap: 10px;
      }

      .doctor-card a {
        font-size: 0.95rem;
        padding: 6px 10px;
        gap: 10px;
      }

      .doctor-card .doctor-specialty {
        font-size: 0.85rem;
        padding: 6px 10px;
        gap: 10px;
      }

      .doctor-card .material-symbols-outlined {
        font-size: 1.2rem;
      }

      .book-appointment {
        padding: 6px 12px;
        font-size: 0.85rem;
      }

      /* Ensure text wraps properly on smaller screens */
      .doctor-card a,
      .doctor-card .doctor-specialty span,
      .book-appointment {
        white-space: normal;
        overflow-wrap: break-word;
        max-width: 100%;
      }
    }

    /* Additional media query for very small screens (e.g., below 360px) */
    @media (max-width: 360px) {
      .chatbot {
        right: 10px;
        bottom: 10px;
        width: calc(100% - 20px);
        height: calc(100% - 70px);
      }

      .chatbot-toggle {
        bottom: 15px;
        right: 15px;
        width: 50px;
        height: 50px;
      }

      .chatbot .chatbox {
        padding: 10px;
      }

      .chatbox .chat p {
        font-size: 0.85rem;
        padding: 8px 12px;
      }

      .doctor-card {
        padding: 10px;
        margin-bottom: 10px;
        gap: 8px;
      }

      .doctor-card a {
        font-size: 0.9rem;
        padding: 5px 8px;
        gap: 8px;
      }

      .doctor-card .doctor-specialty {
        font-size: 0.8rem;
        padding: 5px 8px;
        gap: 8px;
      }

      .doctor-card .material-symbols-outlined {
        font-size: 1.1rem;
      }

      .book-appointment {
        padding: 5px 10px;
        font-size: 0.8rem;
      }
    }
  </style>
</head>

<body>
  <button class="chatbot-toggle">
    <img src="img/chatbot.jpg" alt="Assistant" class="bot-avatar">
  </button>
  <div class="chatbot">
    <header>
      <h2>Health Assistant</h2>
    </header>
    <ul class="chatbox">
      <li class="chat incoming">
        <span class="material-symbols-outlined">smart_toy</span>
        <p>Hi there!<br />How can I help you today?</p>
      </li>
    </ul>
    <div class="chat-input">
      <textarea placeholder="Enter a message..." required></textarea>
      <span id="send-btn" class="material-symbols-outlined">send</span>
    </div>
  </div>
  <script>
    const chatBox = document.querySelector(".chatbox");
    const chatInput = document.querySelector(".chat-input textarea");
    const sendBtn = document.querySelector("#send-btn");
    const toggleBtn = document.querySelector(".chatbot-toggle");
    const body = document.body;

    toggleBtn.addEventListener("click", () => {
      body.classList.toggle("show-chatbot");
    });

    const createChatLi = (message, className) => {
      const chatLi = document.createElement("li");
      chatLi.classList.add("chat", className);
      chatLi.innerHTML = className === "outgoing"
        ? `<p>${message}</p>`
        : `<span class="material-symbols-outlined">smart_toy</span><p>${message}</p>`;
      return chatLi;
    };

    const capitalizeFirstLetter = (string) => string.charAt(0).toUpperCase() + string.slice(1);

    // Function to handle navigation to doctors.php
    const navigateToDoctorsPage = (event) => {
      event.preventDefault();
      if (!window.location.pathname.endsWith('doctors.php')) {
        window.location.href = 'doctors.php';
      }
    }

    // Function to handle navigation to doctor profile with error handling
    const navigateToDoctorProfile = (doctorId, event) => {
      event.preventDefault();
      event.stopPropagation();
      try {
        const url = `doctor_profile.php?id=${doctorId}`;
        window.location.href = url; // Changed from window.open to direct navigation
      } catch (error) {
        console.error('Error opening doctor profile:', error);
        alert('An error occurred while opening the doctor profile. Please try again.');
      }
    }

    async function generateBotResponse(userMessage) {
      const specialties = ["cardiology", "dermatology", "neurology", "pediatrics", "orthopedics", "psychiatry", "gastroenterology", "pulmonology", "endocrinology", "ophthalmology", "ent", "urology", "nephrology", "oncology", "rheumatology", "general surgery", "gynecology", "dentistry", "infectious disease", "immunology", "allergy", "hematology", "plastic surgery", "vascular surgery", "sports medicine", "pain management"];
      const symptomToSpecialty = { 
        "chestpain": "cardiology", "heart palpitations": "cardiology", "skin rash": "dermatology", "acne": "dermatology", 
        "headache": "neurology", "migraine": "neurology", "child fever": "pediatrics", "joint pain": "orthopedics", 
        "broken bone": "orthopedics", "anxiety": "psychiatry", "depression": "psychiatry", "stomach ache": "gastroenterology", 
        "indigestion": "gastroenterology", "shortness of breath": "pulmonology", "cough": "pulmonology", 
        "thyroid problems": "endocrinology", "eye pain": "ophthalmology", "vision loss": "ophthalmology", 
        "ear infection": "ent", "hearing loss": "ent", "urinary infection": "urology", "kidney pain": "nephrology", 
        "blood in urine": "nephrology", "lump or tumor": "oncology", "swollen joints": "rheumatology", 
        "hernia": "general surgery", "pregnancy care": "gynecology", "toothache": "dentistry", "sore throat": "infectious disease", 
        "allergic reaction": "allergy", "low blood count": "hematology", "burn injury": "plastic surgery", 
        "varicose veins": "vascular surgery", "sports injury": "sports medicine", "chronic pain": "pain management" 
      };

      const lowerCaseMessage = userMessage.toLowerCase();

      if (["hi", "hello", "hey"].some(greet => lowerCaseMessage.includes(greet))) {
        return "👋 Hello! How can I assist you today? You can ask about symptoms, specialties, or book an appointment.";
      }
      
      if (lowerCaseMessage.includes("book") || lowerCaseMessage.includes("appointment") || lowerCaseMessage.includes("schedule")) {
        return `
          <div style="display: flex; flex-direction: column; gap: 8px;">
            <span>📅 You can book an appointment with our specialists.</span>
            <a href="doctors.php" class="book-appointment" onclick="event.preventDefault(); navigateToDoctorsPage(event)">
              Book Appointment Now
            </a>
          </div>
        `;
      }
      
      if (lowerCaseMessage.includes("bye") || lowerCaseMessage.includes("goodbye")) {
        return "Goodbye! 👋 Take care and stay healthy!";
      }

      let matchedSpecialty = specialties.find(spec => lowerCaseMessage.includes(spec));
      if (!matchedSpecialty) {
        for (const symptom in symptomToSpecialty) {
          if (lowerCaseMessage.includes(symptom)) {
            matchedSpecialty = symptomToSpecialty[symptom];
            break;
          }
        }
      }

      if (matchedSpecialty) {
        try {
          const response = await fetch('chatbotphp.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message: matchedSpecialty })
          });

          if (!response.ok) {
            const errorText = await response.text();
            console.error('Server error:', response.status, errorText);
            return `⚠️ We're experiencing technical difficulties. Please try again later.`;
          }

          const contentType = response.headers.get('content-type');
          if (contentType && contentType.includes('application/json')) {
            const data = await response.json();
            if (data.success && data.doctors && data.doctors.length > 0) {
              let doctorsList = `
                <div style="display: flex; flex-direction: column; gap: 12px;">
                  <b>🩺 Available ${capitalizeFirstLetter(matchedSpecialty)} Specialists:</b>
              `;
              
              data.doctors.forEach(doctor => {
                const doctorName = doctor.name.trim().replace(/\s+/g, ' ');
                const doctorId = doctor.id || 0; // Ensure doctor ID exists
                
                doctorsList += `
                  <div class="doctor-card">
                    <a href="doctor_profile.php?id=${doctorId}" onclick="event.preventDefault(); navigateToDoctorProfile(${doctorId}, event)">
                      <span class="material-symbols-outlined">medical_services</span>
                      Dr. ${doctorName}
                    </a>
                    <div class="doctor-specialty">
                      <span class="material-symbols-outlined">medical_information</span>
                      <span>${doctor.specialty || 'General Practitioner'}</span>
                    </div>
                    <a href="doctors.php?specialty=${matchedSpecialty}" class="book-appointment" onclick="event.preventDefault(); navigateToDoctorsPage(event)">
                      Book with Dr. ${doctorName}
                    </a>
                  </div>
                `;
              });
              
              doctorsList += `
                <a href="doctors.php?specialty=${matchedSpecialty}" class="book-appointment" onclick="event.preventDefault(); navigateToDoctorsPage(event)">
                  View All ${capitalizeFirstLetter(matchedSpecialty)} Specialists
                </a>
                </div>
              `;
              
              return doctorsList;
            } else {
              return `
                <div style="display: flex; flex-direction: column; gap: 8px;">
                  <span>😔 No ${capitalizeFirstLetter(matchedSpecialty)} specialists available currently.</span>
                  <a href="doctors.php" class="book-appointment" onclick="event.preventDefault(); navigateToDoctorsPage(event)">
                    Browse All Doctors
                  </a>
                </div>
              `;
            }
          } else {
            const responseText = await response.text();
            console.error('Unexpected response format:', responseText);
            return "⚠️ We're having trouble fetching doctor information. Please try again.";
          }
        } catch (error) {
          console.error('Fetch error:', error);
          return "⚠️ Connection error. Please check your internet and try again.";
        }
      }

      return `
        <div style="display: flex; flex-direction: column; gap: 8px;">
          <span>🤖 I'm not sure I understand. You can ask about:</span>
          <ul style="padding-left: 20px; margin: 4px 0;">
            <li>Specific symptoms (e.g., headache, stomach pain)</li>
            <li>Medical specialties (e.g., cardiology, dermaology)</li>
            <li>Booking appointments</li>
          </ul>
          <a href="doctors.php" class="book-appointment" onclick="event.preventDefault(); navigateToDoctorsPage(event)">
            Browse All Doctors
          </a>
        </div>
      `;
    }

    const handleChat = async () => {
      const userMessage = chatInput.value.trim();
      if (!userMessage) return;

      chatBox.appendChild(createChatLi(userMessage, "outgoing"));
      chatBox.scrollTop = chatBox.scrollHeight;
      chatInput.value = "";

      const typingLi = createChatLi("Typing...", "incoming");
      chatBox.appendChild(typingLi);
      chatBox.scrollTop = chatBox.scrollHeight;

      const botReply = await generateBotResponse(userMessage);
      setTimeout(() => {
        typingLi.querySelector("p").innerHTML = botReply;
        chatBox.scrollTop = chatBox.scrollHeight;
        
        // Reattach event listeners to new elements
        document.querySelectorAll('.book-appointment').forEach(link => {
          link.addEventListener('click', navigateToDoctorsPage);
        });
        
        document.querySelectorAll('.doctor-card a[href^="doctor_profile"]').forEach(link => {
          const doctorId = link.getAttribute('href').split('id=')[1];
          link.addEventListener('click', (e) => navigateToDoctorProfile(doctorId, e));
        });
      }, 600);
    };

    sendBtn.addEventListener("click", handleChat);
    chatInput.addEventListener("keypress", (e) => {
      if (e.key === "Enter" && !e.shiftKey) {
        e.preventDefault();
        handleChat();
      }
    });
  </script>
</body>

</html>