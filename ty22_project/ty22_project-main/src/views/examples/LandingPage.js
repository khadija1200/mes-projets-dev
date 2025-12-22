import React, { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import axios from "axios";

// reactstrap components
import {
  Button,
  Input,
  Container,
  Row,
  Col,
  NavItem,
  NavLink,
  Nav,
  TabContent,
  TabPane,
  UncontrolledTooltip,
  Modal,
  ModalBody,
} from "reactstrap";

// core components
import ExamplesNavbar from "components/Navbars/ExamplesNavbar.js";
import LandingPageHeader from "components/Headers/LandingPageHeader.js";
import DefaultFooter from "components/Footers/DefaultFooter.js";

function LandingPage() {
  const { id } = useParams();
  const [prestataire, setPrestataire] = useState(null);
  const [firstFocus, setFirstFocus] = React.useState(false);
  const [lastFocus, setLastFocus] = React.useState(false);
  const [pills, setPills] = React.useState("1");
  const [userId, setUserId] = useState(() => localStorage.getItem("userId"));
  const [role, setRole] = useState(() => localStorage.getItem("role"));
  const navigate = useNavigate();
  const [isFavoris, setIsFavoris] = useState(false);
  const [modalFavoris, setModalFavoris] = useState(false);
  const [favorisMessage, setFavorisMessage] = useState("");
  const [modalReview, setModalReview] = useState(false);
  const [reviewContent, setReviewContent] = useState("");
  const [contactMessage, setContactMessage] = useState(""); // Nouveau state pour le message de contact
  const [contactConfirmation, setContactConfirmation] = useState(""); // Confirmation après l'envoi du message

  useEffect(() => {
    document.body.classList.add("profile-page");
    document.body.classList.add("landing-page");
    document.body.classList.add("sidebar-collapse");
    document.documentElement.classList.remove("nav-open");
    window.scrollTo(0, 0);
    document.body.scrollTop = 0;

    fetch(`http://localhost:3001/api/profilPrestataire/${id}`)
      .then((res) => res.json())
      .then((data) => {
        setPrestataire(data);
        if ((data.posts || []).length > 0) {
          setPills("1");
        }
      })
      .catch((err) => console.error("Erreur de chargement du profil :", err));

    if (userId && id) {
      axios
        .get(`http://localhost:3001/api/favoris1/${userId}`)
        .then((res) => {
          setIsFavoris(res.data.includes(id));
        })
        .catch((err) => console.error("Erreur favoris:", err));
    }

    return function cleanup() {
      document.body.classList.remove("profile-page");
      document.body.classList.remove("landing-page");
      document.body.classList.remove("sidebar-collapse");
    };
  }, [userId, id]);

  const handleLogout = () => {
    setUserId(null);
    setRole(null);
    localStorage.removeItem("userId");
    localStorage.removeItem("role");
    localStorage.removeItem("token");
  };

  const handleToggleFavoris = async () => {
    if (!userId) {
      navigate("/login");
      return;
    }

    try {
      if (isFavoris) {
        await axios.delete(`http://localhost:3001/api/favoris/${userId}/${id}`);
        setFavorisMessage("Professionnel retiré des favoris.");
      } else {
        await axios.post(`http://localhost:3001/api/favoris/${userId}/${id}`);
        setFavorisMessage("Professionnel ajouté aux favoris.");
      }

      setIsFavoris(!isFavoris);
      setModalFavoris(true);
    } catch (error) {
      console.error("Erreur:", error);
      setFavorisMessage("Une erreur est survenue.");
      setModalFavoris(true);
    }
  };

  const handleSubmitReview = async () => {
    if (!userId) {
      navigate("/login");
      return;
    }

    try {
      const res = await axios.post("http://localhost:3001/api/reviews", {
        contenu: reviewContent,
        auteur: userId,
        destinataire: id,
      });

      if (res.status === 201) {
        setReviewContent("");
        setModalReview(false);
        alert("Avis envoyé !");
      }
    } catch (err) {
      console.error("Erreur lors de l'envoi du review :", err);
    }
  };

  const handleSendContactMessage = async () => {
    if (!userId) {
      navigate("/login");
      return;
    }

    try {
      const response = await axios.post("http://localhost:3001/api/messages", {
        contenu: contactMessage,
        auteur: userId,
        destinataire: id,
      });

      if (response.status === 201) {
        setContactMessage(""); // Réinitialiser le champ de message
        setContactConfirmation("Message envoyé avec succès !");
      }
    } catch (error) {
      console.error("Erreur lors de l'envoi du message :", error);
      setContactConfirmation("Une erreur est survenue lors de l'envoi du message.");
    }
  };

  if (!prestataire) {
    return <div style={{ textAlign: "center", marginTop: "100px" }}>Chargement...</div>;
  }

  return (
    <>
      <ExamplesNavbar userId={userId} role={role} onLogout={handleLogout} />
      <div className="wrapper">
        <LandingPageHeader prestataire={prestataire} />
        <div className="section section-about-us">
          <Container>
            <div className="button-container">
              <Button
                className="btn-round"
                color="info"
                size="lg"
                style={{ fontSize: "1rem", padding: "14px 28px" }}
                onClick={() => setModalReview(true)}
              >
                Donner un avis
              </Button>

              {role !== "professionnel" && (
                <>
                  <Button
                    className="btn-round btn-icon"
                    size="lg"
                    onClick={handleToggleFavoris}
                    id="btn-favoris"
                    style={{
                      backgroundColor: isFavoris ? "white" : "#6c757d",
                      border: "1px solid",
                      borderColor: "#6c757d",
                    }}
                  >
                    <i
                      className="now-ui-icons ui-2_favourite-28"
                      style={{
                        color: isFavoris ? "#6c757d" : "white",
                      }}
                    ></i>
                  </Button>
                  <UncontrolledTooltip delay={0} target="btn-favoris">
                    {isFavoris
                      ? "Retirer ce professionnel des favoris"
                      : "Ajouter ce professionnel aux favoris"}
                  </UncontrolledTooltip>
                </>
              )}
            </div>
            <Row>
              <Col className="ml-auto mr-auto text-center" md="8">
                <h2 className="title">Qui suis-je?</h2>
                <h5 className="description">{prestataire.description2}</h5>
              </Col>
            </Row>

            <div className="separator separator-primary"></div>
            <div className="section-story-overview">
              <Row>
                <Col md="6">
                  <div
                    className="image-container image-left"
                    style={{
                      backgroundImage: "url(" + require("assets/img/login.png") + ")",
                    }}
                  >
                    <p className="blockquote blockquote-info">
                      Spécialité : {prestataire.specialite} <br />
                      Ville : {prestataire.ville}
                    </p>
                  </div>
                  {prestataire.posts.length > 0 && (
                    <div
                      className="image-container"
                      style={{
                        backgroundImage: `url(${
                          prestataire.posts[0]?.image
                            ? `http://localhost:3001/${prestataire.posts[0].image}`
                            : "/Profils/default.jpg"
                        })`,
                      }}
                    ></div>
                  )}
                </Col>
                <Col md="5">
                  <div
                    className="image-container image-right"
                    style={{
                      backgroundImage: `url(${
                        prestataire.profil
                          ? `http://localhost:3001/${prestataire.profil}`
                          : "/Profils/default.jpg"
                      })`,
                    }}
                  ></div>
                  <h3>À propos</h3>
                  <p>{prestataire.description}</p>
                  <p>
                    <strong>Adresse :</strong> {prestataire.adresse}
                  </p>
                  <p>
                    <strong>Code postal :</strong> {prestataire.codePostal}
                  </p>
                  <p>
                    <strong>Pays :</strong> {prestataire.pays}
                  </p>
                  <p>
                    <strong>Tarif horaire :</strong> {prestataire.tarifHoraire} €
                  </p>
                  <p>
                    <strong>Site web :</strong>{" "}
                    <a href={prestataire.siteWeb} target="_blank" rel="noopener noreferrer">
                      {prestataire.siteWeb}
                    </a>
                  </p>
                  <br />
                  {prestataire.posts.length > 0 && <p>{prestataire.posts[0].description}</p>}
                </Col>
              </Row>
            </div>

            {/* Formulaire de Contact */}
            <div className="section section-contact-us text-center">
              <Container>
                <h2 className="title">Contacter {prestataire.prenom}</h2>
                <p className="description">Votre projet est important pour nous.</p>
                <Row>
                  <Col className="text-center ml-auto mr-auto" lg="6" md="8">
                    <div className="textarea-container">
                      <Input
                        type="textarea"
                        rows="4"
                        placeholder="Écrivez votre message ici..."
                        value={contactMessage}
                        onChange={(e) => setContactMessage(e.target.value)}
                      />
                    </div>
                    <div className="send-button">
                      <Button
                        block
                        className="btn-round"
                        color="info"
                        onClick={handleSendContactMessage}
                        size="lg"
                      >
                        Envoyer le message
                      </Button>
                    </div>
                    {contactConfirmation && <p className="mt-3">{contactConfirmation}</p>}
                  </Col>
                </Row>
              </Container>
            </div>
          </Container>
        </div>
        <DefaultFooter />
      </div>

      {/* MODAL FAVORIS */}
      <Modal isOpen={modalFavoris} toggle={() => setModalFavoris(false)}>
        <div className="modal-header justify-content-center">
          <button className="close" type="button" onClick={() => setModalFavoris(false)}>
            <i className="now-ui-icons ui-1_simple-remove"></i>
          </button>
          <h4 className="title title-up">Favoris</h4>
        </div>
        <ModalBody>
          <p className="text-center">{favorisMessage}</p>
        </ModalBody>
        <div className="modal-footer">
          <Button color="primary" onClick={() => setModalFavoris(false)}>
            OK
          </Button>
        </div>
      </Modal>

      {/* MODAL REVIEW */}
      <Modal isOpen={modalReview} toggle={() => setModalReview(false)}>
        <div className="modal-header justify-content-center">
          <button className="close" type="button" onClick={() => setModalReview(false)}>
            <i className="now-ui-icons ui-1_simple-remove"></i>
          </button>
          <h4 className="title title-up">Donner un avis</h4>
        </div>
        <ModalBody>
          <Input
            type="textarea"
            rows="4"
            placeholder="Écrivez votre avis ici..."
            value={reviewContent}
            onChange={(e) => setReviewContent(e.target.value)}
          />
        </ModalBody>
        <div className="modal-footer">
          <Button color="info" onClick={handleSubmitReview}>
            Envoyer
          </Button>
          <Button color="secondary" onClick={() => setModalReview(false)}>
            Annuler
          </Button>
        </div>
      </Modal>
    </>
  );
}

export default LandingPage;
