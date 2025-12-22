import React, { useEffect, useState, useRef } from "react";
import { useNavigate } from "react-router-dom";
import { Container } from "reactstrap";
import axios from "axios";

function ProfilePageHeader({ user }) {
  const pageHeader = useRef(null);
  const [favorisCount, setFavorisCount] = useState(0);
  const [avisCount, setAvisCount] = useState(0);
  const navigate = useNavigate();

  useEffect(() => {
    if (window.innerWidth > 991) {
      const updateScroll = () => {
        if (pageHeader.current) {
          let windowScrollTop = window.pageYOffset / 3;
          pageHeader.current.style.transform =
            "translate3d(0," + windowScrollTop + "px,0)";
        }
      };

      window.addEventListener("scroll", updateScroll);

      if (user._id) {
        // ✅ Nombre de favoris
        axios
          .get(`http://localhost:3001/api/favoris/count/${user._id}`)
          .then((res) => setFavorisCount(res.data.count))
          .catch((err) => console.error(err));

        // ✅ Nombre d'avis en fonction du rôle
        axios
          .get(`http://localhost:3001/api/avis/count/${user._id}`)
          .then((res) => {
            console.log("Réponse avis :", res.data);
            setAvisCount(res.data.count);
          })
          .catch((err) => console.error(err));
      }

      updateScroll();

      return function cleanup() {
        window.removeEventListener("scroll", updateScroll);
      };
    }
  }, [user._id]);

  return (
    <>
      <div className="page-header clear-filter page-header-small" filter-color="blue">
        <div
          className="page-header-image"
          style={{
            backgroundImage: "url(" + require("assets/img/login.png") + ")",
          }}
          ref={pageHeader}
        ></div>
        <Container>
          <div className="photo-container">
            <img
              style={{
                width: 160,
                height: 160,
                objectFit: "cover",
                objectPosition: "center",
              }}
              alt="..."
              src={`http://localhost:3001/${user.profil}`}
            />
          </div>
          <h3 className="title" style={{ fontSize: "1.9em" }}>
            {user.prenom} {user.nom}
          </h3>
          <div className="content">
            <div
              className="social-description"
              style={{ cursor: "pointer" }}
              onClick={() => navigate("/review")}
            >
              <h2>{avisCount}</h2>
              <p>Avis</p>
            </div>
            <div
              className="social-description"
              style={{ cursor: user.role === "client" ? "pointer" : "default" }}
              onClick={() => {
                if (user.role === "client") {
                  navigate("/mes-favoris");
                }
              }}
            >
              <h2>{favorisCount}</h2>
              <p>Favoris</p>
            </div>
            <div className="social-description">
              <h2>48</h2>
              <p>Vus</p>
            </div>
          </div>
        </Container>
      </div>
    </>
  );
}

export default ProfilePageHeader;
