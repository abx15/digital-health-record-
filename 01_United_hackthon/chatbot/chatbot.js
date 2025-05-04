
// chatbot.js
// This script handles the chatbot functionality, including sending messages, receiving responses, 
// and displaying doctor information based on user input.
// It also includes a toggle button to show/hide the chatbot interface.
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
    let content =
        className === "outgoing"
            ? `<p>${message}</p>`
            : `<span class="material-icons">smart_toy</span><p>${message}</p>`;
    chatLi.innerHTML = content;
    return chatLi;
};

async function generateBotResponse(userMessage) {
    const specialties = [
        "cardiology", "dermatology", "neurology", "pediatrics", "orthopedics",
        "psychiatry", "gastroenterology", "pulmonology", "endocrinology", "ophthalmology",
        "ent", "urology", "nephrology", "oncology", "rheumatology", "general surgery",
        "gynecology", "dentistry", "infectious disease", "immunology", "allergy",
        "hematology", "plastic surgery", "vascular surgery", "sports medicine", "pain management"
    ];

    const symptomToSpecialty = {
        "chest pain": "cardiology",
        "heart palpitations": "cardiology",
        "skin rash": "dermatology",
        "acne": "dermatology",
        "headache": "neurology",
        "migraine": "neurology",
        "child fever": "pediatrics",
        "joint pain": "orthopedics",
        "broken bone": "orthopedics",
        "anxiety": "psychiatry",
        "depression": "psychiatry",
        "stomach ache": "gastroenterology",
        "indigestion": "gastroenterology",
        "shortness of breath": "pulmonology",
        "cough": "pulmonology",
        "thyroid problems": "endocrinology",
        "eye pain": "ophthalmology",
        "vision loss": "ophthalmology",
        "ear infection": "ent",
        "hearing loss": "ent",
        "urinary infection": "urology",
        "kidney pain": "nephrology",
        "blood in urine": "nephrology",
        "lump or tumor": "oncology",
        "swollen joints": "rheumatology",
        "hernia": "general surgery",
        "pregnancy care": "gynecology",
        "toothache": "dentistry",
        "sore throat": "infectious disease",
        "allergic reaction": "allergy",
        "low blood count": "hematology",
        "burn injury": "plastic surgery",
        "varicose veins": "vascular surgery",
        "sports injury": "sports medicine",
        "chronic pain": "pain management"
    };

    const lowerCaseMessage = userMessage.toLowerCase();
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
            const response = await fetch("chatbotphp.php");
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            const doctors = await response.json();

            if (doctors.error) {
                return `⚠️ Server error: ${doctors.error}`;
            }

            const filteredDoctors = doctors.filter(
                doc => doc.specialty.toLowerCase() === matchedSpecialty
            );

            if (filteredDoctors.length > 0) {
                let doctorsList = `<b>🩺 Based on your symptoms, here are available doctors:</b><br><br>`;
                filteredDoctors.forEach(doctor => {
                    doctorsList += `
                <div style="margin-bottom: 12px; padding: 15px; border: 1px solid #e0e0e0; border-radius: 15px; background: #ffffff; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                  <a href="doctor_profile.php?id=${doctor.id}" target="_blank" style="font-weight:bold; font-size: 1.1rem; color:#007bff; text-decoration:none;">
                    🧑‍⚕️ Dr. ${doctor.fullname}
                  </a><br><br>
                  <span style="font-size:12px;">🔬 <b>Specialty:</b> ${doctor.specialty}</span><br>
                  <span style="font-size: 12px;">📅 <b>Days:</b> ${doctor.availability_days}</span><br>
                  <span style="font-size: 12px;">⏰ <b>Time:</b> ${doctor.availability_time}</span>
                  
                </div>
              `;
                });
                return doctorsList;
            } else {
                return `😔 No doctors available for ${capitalizeFirstLetter(matchedSpecialty)}.`;
            }
        } catch (error) {
            console.error("Fetch error:", error);
            return "⚠️ Unable to fetch doctor data. Please try again later.";
        }
    }

    if (lowerCaseMessage.includes("book") || lowerCaseMessage.includes("appointment") || lowerCaseMessage.includes("schedule")) {
        return `📅 You can book an appointment here: <a href='appointment_form.php' target='_blank' style="color: #724ae8;">Book Now</a>`;
    }

    if (["hi", "hello", "hey"].some(greet => lowerCaseMessage.includes(greet))) {
        return "Hello! 👋 How can I assist you today?";
    }

    if (lowerCaseMessage.includes("thank")) {
        return "You're welcome! 😊";
    }

    if (lowerCaseMessage.includes("bye") || lowerCaseMessage.includes("goodbye")) {
        // Remove typing indicator if it exists
        if (typingLi) {
            typingLi.remove();
            typingLi = null;
        }
        return "Goodbye! 👋 Take care!";
    }

    return "🤔 Sorry, I didn't understand. Try asking about symptoms, doctors, booking appointments, or reports.";
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

let typingLi = null;


const handleChat = async () => {
    let userMessage = chatInput.value.trim();
    if (!userMessage) return;

    // Add user message
    chatBox.appendChild(createChatLi(userMessage, "outgoing"));
    chatBox.scrollTop = chatBox.scrollHeight;
    chatInput.value = "";

    // Remove previous typing indicator if it exists
    if (typingLi) {
        typingLi.remove();
        typingLi = null;
    }

    // Add typing indicator
    typingLi = createChatLi("Typing...", "incoming");
    chatBox.appendChild(typingLi);
    chatBox.scrollTop = chatBox.scrollHeight;

    // Get bot response
    const botReply = await generateBotResponse(userMessage);

    // Update typing indicator with response
    typingLi.querySelector("p").innerHTML = botReply;
    typingLi = null; // Clear typingLi reference
    chatBox.scrollTop = chatBox.scrollHeight;
};

sendBtn.addEventListener("click", handleChat);

chatInput.addEventListener("keypress", (e) => {
    if (e.key === "Enter" && !e.shiftKey) {
        e.preventDefault();
        handleChat();
    }
});
