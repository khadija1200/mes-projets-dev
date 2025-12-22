import React from "react";
import { useNavigate } from "react-router-dom";
import "../../assets/css/PrestataireCard.css";

const PrestataireCard = ({ id, profil, nom, prenom, description }) => {
  const navigate = useNavigate();

  const handleClick = () => {
    navigate(`/profilPrestataire/${id}`);
  };

  return (
    <div className="prestataire-card" onClick={handleClick} style={{ cursor: "pointer" }}>
      <img src={profil || "/Profils/default.jpg"} alt={`Profil de ${prenom} ${nom}`} />
      <div className="prestataire-info">
        <h2>{prenom} {nom}</h2>
        <p>{description}</p>
      </div>
    </div>
  );
};

export default PrestataireCard;
