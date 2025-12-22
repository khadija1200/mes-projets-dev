// Tutorial.js
import React from "react";
import { Container, Row, Col, Button } from "reactstrap";
import avatar from "assets/img/search.jpg";
import ryan from "assets/img/contat.png";
import eva from "assets/img/prestatire.png";

const Tutorial = () => {
  return (
    <div className="section section-team text-center">
      <Container>
        <h2 className="title">Comment ça marche ?</h2>
        <div className="team">
          <Row>
            {/* Step 1 */}
            <Col md="4">
              <div className="team-player">
                <img
                  alt="Romina"
                  src={avatar}
                  className="rounded-circle img-raised"
                  style={{ width: "150px", height: "150px", objectFit: "cover" }}
                />
                <h4 className="title">Recherchez des artisans et des professionnels prés de chez vous en utilisant la barre de recherche.</h4>
              </div>
            </Col>

            {/* Step 2 */}
            <Col md="4">
              <div className="team-player">
                <img
                  alt="Ryan"
                  src={ryan}
                  className="rounded-circle img-raised"
                  style={{ width: "150px", height: "150px", objectFit: "cover" }}
                />
                <h4 className="title">Accéder au compte de nos prestataires dans la messagerie integrée ou directement en récupérant leur coordonnées.</h4>
              </div>
            </Col>

            {/* Step 3 */}
            <Col md="4">
              <div className="team-player">
                <img
                  alt="Eva"
                  src={eva}
                  className="rounded-circle img-raised"
                  style={{ width: "150px", height: "150px", objectFit: "cover" }}
                />
                <h4 className="title">Discutez avec eux et fixer une date et un horaire pour béneficier de la prestation.</h4>
              </div>
            </Col>
          </Row>
        </div>
      </Container>
    </div>
  );
};

export default Tutorial;
