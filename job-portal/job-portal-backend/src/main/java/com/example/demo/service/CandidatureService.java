package com.example.demo.service;

import com.example.demo.dto.CandidatureRequest;
import com.example.demo.model.Candidature;
import com.example.demo.model.CandidatureStatus;
import com.example.demo.model.Recruiter;
import com.example.demo.model.User;
import com.example.demo.repository.CandidatureRepository;
import com.example.demo.repository.RecruiterRepository;
import com.example.demo.repository.UserRepository;
import org.springframework.stereotype.Service;
import org.springframework.web.multipart.MultipartFile;

import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.List;

@Service
public class CandidatureService {

    private final CandidatureRepository candidatureRepository;
    private final RecruiterRepository recruiterRepository;
    private final UserRepository userRepository;

    public CandidatureService(
            CandidatureRepository candidatureRepository,
            RecruiterRepository recruiterRepository,
            UserRepository userRepository) {
        this.candidatureRepository = candidatureRepository;
        this.recruiterRepository = recruiterRepository;
        this.userRepository = userRepository;
    }

    // CREATE JSON
    public Candidature create(CandidatureRequest request) {

        User candidat = userRepository.findById(request.getCandidatId())
                .orElseThrow(() -> new RuntimeException("User not found"));

        Recruiter recruiter = recruiterRepository.findById(request.getRecruiterId())
                .orElseThrow(() -> new RuntimeException("Recruiter not found"));

        Candidature c = new Candidature();
        c.setPoste(request.getPoste());
        c.setMessage(request.getMessage());
        c.setCandidat(candidat);
        c.setRecruiter(recruiter);
        c.setStatus(CandidatureStatus.EN_ATTENTE);

        return candidatureRepository.save(c);
    }

    // CREATE WITH FILE
    public Candidature createWithFile(
            String poste,
            String message,
            Long recruiterId,
            Long candidatId,
            MultipartFile file) throws Exception {

        User candidat = userRepository.findById(candidatId)
                .orElseThrow(() -> new RuntimeException("User not found"));

        Recruiter recruiter = recruiterRepository.findById(recruiterId)
                .orElseThrow(() -> new RuntimeException("Recruiter not found"));

        Candidature c = new Candidature();
        c.setPoste(poste);
        c.setMessage(message);
        c.setCandidat(candidat);
        c.setRecruiter(recruiter);
        c.setStatus(CandidatureStatus.EN_ATTENTE);

        if (file != null && !file.isEmpty()) {

            String uploadDir = System.getProperty("user.dir") + "/uploads/";
            Files.createDirectories(Paths.get(uploadDir));

            String fileName = System.currentTimeMillis() + "_" + file.getOriginalFilename();
            Path path = Paths.get(uploadDir + fileName);

            file.transferTo(path.toFile());

            // ⚠️ ON GARDE uploads/ si tu l’utilises déjà en DB
            c.setCvUrl("uploads/" + fileName);
        }
        return candidatureRepository.save(c);
    }

    // GET ALL
    public List<Candidature> getAll() {
        return candidatureRepository.findAll();
    }

    // GET BY CANDIDAT
    public List<Candidature> getByCandidat(Long candidatId) {
        return candidatureRepository.findByCandidatId(candidatId);
    }

    // ✅ GET BY RECRUTEUR (FIX IMPORTANT)
    public List<Candidature> getByRecruiter(Long recruiterId) {
        return candidatureRepository.findByRecruiterId(recruiterId);
    }

    // GET BY ID
    public Candidature getById(Long id) {
        return candidatureRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Candidature not found"));
    }

    // UPDATE STATUS
    public Candidature updateStatus(Long id, CandidatureStatus status) {
        Candidature c = candidatureRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Candidature not found"));

        c.setStatus(status);
        return candidatureRepository.save(c);
    }

    // DELETE
    public void delete(Long id) {
        candidatureRepository.deleteById(id);
    }
}