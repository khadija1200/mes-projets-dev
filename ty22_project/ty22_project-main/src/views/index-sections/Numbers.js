import React, { useEffect, useState } from "react";
import { Container, Row, Col } from "reactstrap";
import axios from "axios";

const Number = () => {
  const [totalPrestataires, setTotalPrestataires] = useState(0);
  const [totalSpecialites, setTotalSpecialites] = useState(0);

  useEffect(() => {
    axios.get("http://localhost:3001/api/stats")
      .then((res) => {
        setTotalPrestataires(res.data.professionnelsCount);
        setTotalSpecialites(res.data.specialiteCount);
      })
      .catch((err) => {
        console.error("Erreur lors du chargement des statistiques :", err);
      });
  }, []);

  return (
    <div className="section text-center">
      <Container>
        <h2 className="title">Quelques chiffres clés</h2>
        <Row className="justify-content-center">
          <Col md="4">
            <div className="stat-box">
              <h1 className="display-3 font-weight-bold text-primary">
                {totalPrestataires}
              </h1>
              <p className="lead">Prestataires inscrits</p>
            </div>
          </Col>
          <Col md="4">
            <div className="stat-box">
              <h1 className="display-3 font-weight-bold text-success">
                {totalSpecialites}
              </h1>
              <p className="lead">Spécialités disponibles</p>
            </div>
          </Col>
        </Row>
      </Container>
    </div>
  );
};

export default Number;
