import React, { useEffect, useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import _ from "lodash";
import { FaPaperPlane } from "react-icons/fa";
import ExamplesNavbar from "components/Navbars/ExamplesNavbar.js";
import ProfilePageHeader from "components/Headers/ProfilePageHeader.js";
import DefaultFooter from "components/Footers/DefaultFooter.js";

function Messages() {
  const [userData, setUserData] = useState(null);
  const [contacts, setContacts] = useState([]);
  const [selectedContact, setSelectedContact] = useState(null);
  const [messages, setMessages] = useState([]);
  const [messageInput, setMessageInput] = useState("");
  const navigate = useNavigate();
  const [userId, setUserId] = useState(() => localStorage.getItem("userId"));
  const [role, setRole] = useState(() => localStorage.getItem("role"));

  // Effect pour récupérer les informations de l'utilisateur et ses contacts
  useEffect(() => {
    const fetchUser = async () => {
      try {
        const res = await axios.get(`http://localhost:3001/api/user/${userId}`);
        setUserData(res.data.user);
      } catch (err) {
        console.error(err);
      }
    };

    const fetchContacts = async () => {
      try {
        const res = await axios.get(`http://localhost:3001/api/contacts/${userId}`);
        setContacts(res.data);
      } catch (err) {
        console.error("Erreur récupération contacts :", err);
      }
    };

    if (userId) {
      fetchUser();
      fetchContacts();
    }

    document.body.classList.add("profile-page");
    document.body.classList.add("sidebar-collapse");
    document.documentElement.classList.remove("nav-open");
    window.scrollTo(0, 0);

    const calcInnerHeight = () => {
      const vh = window.innerHeight * 0.01;
      document.documentElement.style.setProperty("--vh", `${vh}px`);
    };
    const debounced = _.debounce(calcInnerHeight, 66);
    window.addEventListener("resize", debounced);
    calcInnerHeight();

    return () => {
      document.body.classList.remove("profile-page");
      document.body.classList.remove("sidebar-collapse");
      window.removeEventListener("resize", debounced);
    };
  }, [userId]);

  // Effect pour récupérer les messages d'une conversation spécifique
  useEffect(() => {
    if (selectedContact) {
      axios
        .get(`http://localhost:3001/api/messages/conversation/${userId}/${selectedContact._id}`)
        .then((res) => {
          const sortedMessages = res.data.sort((a, b) => new Date(a.createdAt) - new Date(b.createdAt));
          setMessages(sortedMessages);
        })
        .catch((err) => console.error("Erreur récupération messages :", err));
    }
  }, [selectedContact, userId]);

  // Fonction de déconnexion
  const handleLogout = () => {
    setUserId(null);
    setRole(null);
    localStorage.removeItem("userId");
    localStorage.removeItem("role");
    localStorage.removeItem("token");
    navigate("/index");
  };
  
  // Fonction pour envoyer un message
  const handleSendMessage = async (e) => {
    e.preventDefault();
    if (!messageInput.trim() || !selectedContact) return;

    try {
      await axios.post("http://localhost:3001/api/messages", {
        contenu: messageInput,
        auteur: userId,
        destinataire: selectedContact._id,
      });
      setMessageInput("");
      const res = await axios.get(`http://localhost:3001/api/messages/conversation/${userId}/${selectedContact._id}`);
      const sortedMessages = res.data.sort((a, b) => new Date(a.createdAt) - new Date(b.createdAt));
      setMessages(sortedMessages);
    } catch (err) {
      console.error("Erreur lors de l'envoi :", err);
    }
  };

  if (!userData) return <p>Chargement...</p>;

  return (
    <>
      <ExamplesNavbar userId={userId} role={role} onLogout={handleLogout} />
      <div className="wrapper">
        <ProfilePageHeader user={userData} />

        <div className="section">
          <div style={{ padding: "2em" }}>
            <div style={{ display: "flex", justifyContent: "center", gap: "4em", flexWrap: "wrap" }}>
              {/* Zone messages */}
              <div style={{ flex: "2", maxWidth: "600px", display: "flex", flexDirection: "column", gap: "1.5em" }}>
                {selectedContact ? (
                  <>
                    <div style={{ display: "flex", flexDirection: "column", gap: "2em" }}>
                      {messages.map((msg, i) => {
                        const isMe = msg.auteur._id === userId;
                        return (
                          <div
                            key={i}
                            style={{
                              display: "flex",
                              flexDirection: isMe ? "row-reverse" : "row",
                              alignItems: "flex-start",
                              gap: "0.6em",
                            }}
                          >
                            {!isMe && (
                              <div style={{ display: "flex", flexDirection: "column", alignItems: "center", minWidth: "60px" }}>
                                <img
                                  src={`http://localhost:3001/${msg.auteur.profil}` || "https://via.placeholder.com/36"}
                                  alt={msg.auteur.prenom}
                                  style={{ width: "36px", height: "36px", borderRadius: "50%", objectFit: "cover" }}
                                />
                                <div style={{ fontSize: "0.75em", color: "#888", textAlign: "center" }}>
                                  {msg.auteur.prenom}
                                </div>
                              </div>
                            )}
                            <div
                              style={{
                                padding: "0.8em 1em",
                                borderRadius: "20px",
                                fontSize: "0.95em",
                                maxWidth: "80%",
                                backgroundColor: isMe ? "#e0e0e0" : "#2ca8ff",
                                color: isMe ? "#444" : "#fff",
                                borderTopLeftRadius: "20px",
                                borderTopRightRadius: "20px",
                                borderBottomLeftRadius: isMe ? "20px" : "0px",
                                borderBottomRightRadius: isMe ? "0px" : "20px",
                                boxShadow: "0 1px 3px rgba(0, 0, 0, 0.1)",
                              }}
                            >
                              {msg.contenu}
                            </div>
                          </div>
                        );
                      })}
                    </div>
                    <form onSubmit={handleSendMessage} style={{ marginTop: "2em", display: "flex", gap: "0.5em" }}>
                        <input
                            type="text"
                            placeholder="Tape ton message ici"
                            value={messageInput}
                            onChange={(e) => setMessageInput(e.target.value)}
                            style={{
                            flex: 1,
                            padding: "0.8em 1em",
                            border: "1px solid #ccc",
                            borderRadius: "10px",
                            outline: "none",
                            fontSize: "1em",
                            }}
                        />
                        <button
                            type="submit"
                            disabled={!messageInput.trim()} // désactive si champ vide
                            style={{
                            backgroundColor: "#2ca8ff",
                            border: "none",
                            padding: "0.6em 0.9em",
                            borderRadius: "10px",
                            cursor: messageInput.trim() ? "pointer" : "not-allowed",
                            color: "#fff",
                            display: "flex",
                            alignItems: "center",
                            justifyContent: "center",
                            }}
                        >
                            <FaPaperPlane />
                        </button>
                        </form>
                  </>
                ) : (
                  <div style={{ fontSize: "1em", color: "#666", textAlign: "center" }}>
                    Sélectionne un contact pour démarrer la conversation.
                  </div>
                )}
              </div>

              {/* Zone contacts */}
              <div style={{ flex: "1", maxWidth: "250px" }}>
                {contacts.map((contact) => (
                  <div
                    key={contact._id}
                    onClick={() => setSelectedContact(contact)}
                    style={{
                      display: "flex",
                      alignItems: "center",
                      gap: "0.8em",
                      marginBottom: "1em",
                      cursor: "pointer",
                      backgroundColor: selectedContact?._id === contact._id ? "#f0f0f0" : "transparent",
                      borderRadius: "8px",
                      padding: "0.5em",
                    }}
                  >
                    <img
                      src={`http://localhost:3001/${contact.profil}` || "https://via.placeholder.com/40"}
                      alt={contact.prenom}
                      style={{ width: "40px", height: "40px", borderRadius: "50%", objectFit: "cover" }}
                    />
                    <span style={{ fontSize: "0.9em", fontWeight: 500, color: "#444" }}>
                      {contact.prenom} {contact.nom}
                    </span>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>

        <DefaultFooter />
      </div>
    </>
  );
}

export default Messages;
