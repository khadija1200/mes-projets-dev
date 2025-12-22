import React, { useEffect, useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";

// core components
import ExamplesNavbar from "components/Navbars/ExamplesNavbar.js";
import ProfilePageHeader from "components/Headers/ProfilePageHeader.js";
import DefaultFooter from "components/Footers/DefaultFooter.js";

function Review() {
  const [userData, setUserData] = useState(null);
  const [reviews, setReviews] = useState([]);
  const navigate = useNavigate();
  const [userId, setUserId] = useState(() => localStorage.getItem("userId"));
  const [role, setRole] = useState(() => localStorage.getItem("role"));

  useEffect(() => {
    if (userId) {
      axios
        .get(`http://localhost:3001/api/user/${userId}`)
        .then((res) => setUserData(res.data))
        .catch((err) => console.error(err));

      axios
        .get(`http://localhost:3001/api/reviews/${userId}`)
        .then((res) => setReviews(res.data))
        .catch((err) => console.error("Erreur en récupérant les avis :", err));
    }

    document.body.classList.add("profile-page");
    document.body.classList.add("sidebar-collapse");
    document.documentElement.classList.remove("nav-open");
    window.scrollTo(0, 0);

    return () => {
      document.body.classList.remove("profile-page");
      document.body.classList.remove("sidebar-collapse");
    };
  }, [userId]);

  const handleLogout = () => {
    setUserId(null);
    setRole(null);
    localStorage.clear();
    navigate("/index");
  };

  if (!userData) return <p>Chargement...</p>;

  const { user } = userData;

  return (
    <>
      <ExamplesNavbar userId={userId} role={role} onLogout={handleLogout} />
      <div className="wrapper">
        <ProfilePageHeader user={user} />

        <div className="section">
          <div className="container">
            <h3 className="title text-center">
              {user.role === "professionnel" ? "Avis reçus" : "Avis envoyés"}
            </h3>

            {reviews.length === 0 ? (
              <p className="text-center">Aucun avis pour le moment.</p>
            ) : (
              reviews.map((review) => {
                const displayedUser =
                  user.role === "professionnel"
                    ? review.auteur
                    : review.destinataire;

                return (
                  <div key={review._id} className="card mb-3 p-3">
                    <div className="d-flex align-items-center">
                      <img
                        src={`http://localhost:3001/${displayedUser.profil}`}
                        alt="profil"
                        style={{
                          width: 50,
                          height: 50,
                          borderRadius: "50%",
                          objectFit: "cover",
                          marginRight: 15,
                        }}
                      />
                      <div>
                        <h5 className="mb-0">
                          {displayedUser.prenom} {displayedUser.nom}
                        </h5>
                        <small className="text-muted">
                          {new Date(review.createdAt).toLocaleDateString()}
                        </small>
                      </div>
                    </div>
                    <p className="mt-2">{review.contenu}</p>
                  </div>
                );
              })
            )}
          </div>
        </div>

        <DefaultFooter />
      </div>
    </>
  );
}

export default Review;
